<?php

class Pagination
{
	private $dbh;
	private $config;

	private $table;
	private $total;
	private $limit;
	private $offset;
	private $pages;

	public $category = null;
	public $page;

	private $page_url;

	public function __construct()
	{
		// initialize configs
		$this->config = new Config();

		// initialize the PDO handler
		try
		{
			$this->dbh = new PDO($this->config->getHostDB(), $this->config->getUserDB(), $this->config->getPassDB(), $this->config->getCharDB());
		}
		catch (Exception $e)
		{
			//echo "No connection to database: ",  $e->getMessage(), "\n";
			echo 'No connection to database.';
		}
	}

	public function setLimit($limit)
	{
		if ( $this->limit = intval($limit) )
		{
			return true;
		}

		return false;
	}

	public function setTable($table)
	{
		if ( Validate::Get($table) )
		{
			// mysql_real_escape_string need a mysql_connect before (sometimes)
			// dont use mysql_real... @TODO
			$this->table = mysql_real_escape_string($table);
			return true;
		}

		return false;
	}

	public function setCategory($category)
	{
		if ( Validate::Get($category) )
		{
			$this->category = $category;
			return true;
		}

		return false;
	}

	public function setTotal()
	{
		if ( $this->category != null )
		{
			$sql = "SELECT COUNT(*) FROM $this->table WHERE category = :category";
			$execute_array = array(':category' => $this->category);
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM $this->table";
			$execute_array = array();
		}
		
		$sth = $this->dbh->prepare($sql);
		
		if ( $sth->execute($execute_array) )
		{
			$this->total = $sth->fetchColumn();
			return true;
		}

		return false;
	}

	public function setPages()
	{
		if ( $this->pages = ceil($this->total / $this->limit) )
		{
			return true;
		}

		return false;
	}
	
	public function setOffset()
	{
		if ( $this->offset = ($this->page - 1) * $this->limit )
		{
			return true;
		}

		return false;
	}

	public function setPage($page)
	{
		if ( $this->page = intval($page) )
		{
			return true;
		}

		return false;
	}

	public function getData()
	{
		if ( $this->category == null )
		{
			$sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT :limitvar OFFSET :offsetvar";
		}
		else
		{
			$sql = "SELECT * FROM $this->table WHERE category = :category ORDER BY id DESC LIMIT :limitvar OFFSET :offsetvar";
		}

		$sth = $this->dbh->prepare($sql);

		if ( !$this->category == null )
		{
			$sth->bindValue(':category', $this->category);
		}

		$sth->bindValue(':limitvar', (int) $this->limit, PDO::PARAM_INT);
		$sth->bindValue(':offsetvar', (int) $this->offset, PDO::PARAM_INT);

		$sth->execute();
		//echo $sql;
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);

		//return json_encode($result);
		return $result;
	}

	public function getDataJSON()
	{
		return json_encode($this->getData());
	}

	public function getDebug()
	{
		return array('offset' => $this->offset, 'limit' => $this->limit, 'pages' => $this->pages, 'total' => $this->total, 'page' => $this->page);
	}

	public function showPagination()
	{
		echo '<ul class="pagination">';
		echo '<li> <a href="' . $this->createPaginationLink($this->getBackValue()) . '">&laquo;</a> </li>';

		for ($i=1; $i <= $this->pages; $i++)
		{ 
			if ( $i == $this->page )
			{
				echo '<li class="active"> <a href="' . $this->createPaginationLink($i) . '">' . $i . '</a> </li>';
			}
			else
			{
				echo '<li> <a href="' . $this->createPaginationLink($i) . '">' . $i . '</a> </li>';
			}
		}

		echo '<li> <a href="' . $this->createPaginationLink($this->getForwardValue()) . '">&raquo;</a> </li>';
		echo '</ul>';
	}

	public function setPageLink($filepath)
	{
		$this->page_url = $filepath;
	}

	private function createPaginationLink($page_number)
	{
		$pagination_link = $this->page_url . '?page=' . $page_number;

		if ( !empty($this->category) )
		{
			$pagination_link .= '&category=' . $this->category;
		}

		return $pagination_link;
	}

	private function getBackValue()
	{
		if ( ($this->page - 1) < 1 )
		{
			return 1;
		}
		else
		{
			return $this->page - 1;
		}
	}

	private function getForwardValue()
	{
		if ( ($this->page + 1) > $this->pages )
		{
			return $this->pages;
		}
		else
		{
			return $this->page + 1;
		}
	}
}

?>