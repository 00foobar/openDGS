<?php

class Product
{
	private $dbh;
	private $config;

	private $mime_whitelist = array('image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/tiff', 'image/svg+xml');

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
			// echo "No connection to database: ",  $e->getMessage(), "\n";
			echo 'No connection to database.';
		}
	}

	// get all products
	public function getAllProducts()
	{
		$sql = "SELECT * FROM products";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		if ( $sth->rowCount() > 0 )
		{
			return $sth->fetchAll();
		}
		
		return false;
	}

	// get all categories
	public function getCategories()
	{
		$sql = "SELECT category FROM products";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		if ( $sth->rowCount() > 0 )
		{
			$categories = $sth->fetchAll(PDO::FETCH_COLUMN);

			//return $categories;
			return array_unique($categories);
		}

		return false;
	}

	// get a array of all products with given categorie set
	public function getProductsByCategory($category)
	{
		$sql = "SELECT * FROM products WHERE category = :category";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':category' => $category));

		if ( $sth->rowCount() > 0 )
		{
			return $sth->fetchAll();
		}

		return false;
	}

	// get the product array by id
	public function getProductById($id)
	{
		if ( !is_int($id) )
		{
			return false;
		}

		$sql = "SELECT * FROM products WHERE id = :id";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':id' => $id));

		if ( $sth->rowCount() > 0 )
		{
			$result = $sth->fetchAll();

			return $result[0];
		}

		return false;
	}

	// creates a product in the database
	public function createProduct($name, $category, $price, $desc, $image_url)
	{
		if ( !Validate::Get($name) )
		{
			throw new Exception("Error Processing Request", 1);
			return false;
		}

		if ( !Validate::Get($category) )
		{
			throw new Exception("Error Processing Request", 1);
			return false;
		}

		if ( !Validate::issetValidation($price) && !is_float($price) )
		{
			throw new Exception("Error Processing Request", 1);
			return false;
		}

		if ( !Validate::issetValidation($desc) && !is_string($desc) )
		{
			throw new Exception("Error Processing Request", 1);
			return false;
		}

		if ( !Validate::issetValidation($image_url) && !is_string($image_url) )
		{
			throw new Exception("Error Processing Request", 1);
			return false;
		}
		else
		{
			if ( !file_exists($image_url) )
			{
				throw new Exception("Error Processing Request", 1);
				return false;
			}

			$status = false;
			$file_mime = mime_content_type($image_url);

			foreach ($this->mime_whitelist as $mime)
			{
				if ( $mime == $file_mime )
				{
					$status = true;
					break;
				}
			}

			if ( !$status )
			{
				throw new Exception("Error Processing Request", 1);
				return false;
			}
		}

		// things look good...
		$sql = "INSERT INTO products (name, price, category, description, image_url) VALUES (:name, :price, :category, :description, :image_url)";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':name' => $name, ':price' => $price, ':category' => $category, ':description' => $description, ':image_url' => $image_url));

		if ( $sth->rowCount() > 0 )
		{
			return true; // change to id, maybe.
		}
	}


	// edit the given params of a already exists product (selected by the id)
	public function editProduct($id, $name = null, $categorie = null, $price = null, $desc = null, $image_url = null)
	{

	}
}

?>