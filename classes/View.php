<?php

class View
{
	private $product_handler;
	private $user_handler;
	private $config;

	public $category;
	public $products;

	private $pages;

	public function __construct()
	{
		// initialize the config class
		$this->config = new Config();

		// initalize the product class
		$this->product_handler = new Product();

		// initialize the user class
		$this->user_handler = new User();
	}

	// show products from the given array
	public function showProducts($products)
	{
		$i = 0;

		if ( is_array($products) )
		{

			// iterate the given products array
			foreach ($products as $product)
			{
				$i++;

				$description = $this->getDescriptionPreview($product['description']);

				// print the products container
				if ( $i == 1 ) echo '<div class="row-eq-height">';

				// print the item
				echo '<div class="col-md-4 product-item">';
				echo '	<a href="product.php?id=' . $product['id'] . '">';
				echo '		<div class="image-background"><img class="img-responsive center-block" src="' . $product['image_url'] . '" alt=""></div>';
				echo '	</a>';
				echo '	<h3><a href="product.php?id=' . $product['id'] . '">' . $product['name'] . '</a></h3>';
				echo '	<p>' . $description . '</p>';
				echo '</div>';

				// do clearfix after three iterations (three items inline)
				if ( $i == 3 )
				{
					echo '</div>';
					echo '<div class="clearfix"></div>';
					$i = 0;
				}
			}
		}
		else
		{
			throw new Exception("Input must be an array.", 1);
			return false;
		}
	}

	public function getDescriptionPreview($description)
	{
		if ( strlen($description) > 200 )
		{
			$first_newline = strpos($description, "\n");

			if ( $first_newline != 0 )
			{
				return nl2br(substr($description, 0, $first_newline));	
			}
			else
			{
				return nl2br(substr($description, 0, 200) . ' [...]');
			}
		}

		return nl2br($description);
	}

	// show the given product with the productinformation in the given array
	public function showProduct($product)
	{
		echo '<div class="row">';

		echo '<div class="col-xs-12 col-sm-3"><img class="img-responsive center-block" src="' . $product['image_url'] . '"></div>';

		echo '<div class="col-xs-12 col-sm-9 product-text center-block">';

		echo '<h1>' . $product['name'] . '</h1>';

		echo '<p>' . nl2br($product['description']) . '</p>';

		echo '<ul><li class="product-category">Category: ' . $product['category'] . '</ul></li>';

		echo '<h3>' . $product['price'] . ' ' . $this->config->shop_currency . '</h3>';

		echo '</div>';

		echo '<div class="col-xs-12 product-row">
				<div class="well">
					<div class="row">';

		if ( $this->user_handler->isLoggedIn() )
		{
			echo '		<div class="col-xs-12 col-sm-4 product-subitem text-center">
							<a title="Download" href="checkout.php?id='.$product['id'].'" class="btn btn-warning btn-large btn-block">
							<i class="glyphicon glyphicon-flash"></i> DOWNLOAD NOW<br><small>FOR ONLY ' . $product['price'] . ' ' . $this->config->shop_currency . '</small></a>
							<i class="glyphicon glyphicon-ok"></i> Available instantly after purchase    
						</div>';
		}
		else
		{
			echo '		<div class="col-xs-12 col-sm-4 product-subitem text-center">
							<button type="button" class="btn btn-lg" data-toggle="modal" data-target="#mobile-login-modal">Login</button>   
						</div>';
		}


		echo '			<div class="col-xs-12 col-sm-5 product-subitem"><em>Including one year of personal support and updates, and the unencrypted extension for use on unlimited sites, excluding 21% VAT which may apply to EU orders</em></div>
						<div class="col-xs-12 col-sm-3 product-subitem"><img class="img-responsive center-block" src="http://www.chillcreations.com/images/productpage/buy_now/payment_methods.png" alt="Accepted payment methods"></div>
					</div>
				</div>
			</div>';

		echo '</div>';
	}

	// show all product categories as list elements
	public function showCategories()
	{
		$categories = $this->product_handler->getCategories();

		foreach ($categories as $category)
		{
			echo '<li><a href="index.php?category=' . $category . '">' . $category . '</a></li>';
		}
	}

	// shows the admin menu
	public function showAdminMenu()
	{
		echo '	<li><a href="index.php">Overview</a></li>
				<li><a href="orders.php">Orders</a></li>
				<li><a href="products.php">Products</a></li>
				<li><a href="users.php">Users</a></li>
				<li><a href="tickets.php">Tickets</a></li>
				<li><a href="faq.php">FAQ</a></li>
				<li><a href="payments.php">Payment</a></li>
				<li><a href="settings.php">Settings</a></li>';
	}

	// shows the user menu
	public function showUserMenu()
	{
		$is_admin = $this->user_handler->isAdmin();

		// print the unsorted list container
		echo '<ul class="nav navbar-nav">';

		// print the list elements
		echo '	<li>
					<a href="index.php">Home</a>
				</li>';


		if ( $is_admin == false )
		{
			echo '	<li>
						<a href="orders.php">Orders</a>
					</li>
					<li>
						<a href="inventar.php">Inventar</a>
					</li>
					<li>
						<a href="faq.php">FAQ</a>
					</li>
					<li>
						<a href="contact.php">Contact</a>
					</li>';
		}

		echo '	<li>
					<a href="impress.php">Impress</a>
				</li>
				<li>
					<a href="conditions.php">Conditions</a>
				</li>';

		// if user is admin show the link to adminpanel
		if ( $is_admin )
		{
			echo '	<li>
						<a href="admin/">Adminpanel</a>
					</li>';
		}

		// print the unsorted list closing tag
		echo '</ul>';
	}

	// show the guest (not logged in) menu
	public function showGuestMenu()
	{
		// print the unsorted list container
		echo '<ul class="nav navbar-nav">';

		// print the list elements
		echo '	<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="faq.php">FAQ</a>
				</li>
				<li>
					<a href="impress.php">Impress</a>
				</li>
				<li>
					<a href="conditions.php">Conditions</a>
				</li>';

		// print the unsorted list closing tag
		echo '</ul>';
	}

	// show the logout formular
	public function showLogoutForm()
	{
		echo '	<button id="logout-button" class="btn btn-error btn-sm">Logout</button>
				<button id="profile-bitton" class="btn btn-primary btn-sm">Profile</button>';
	}

	// show the inline login formular
	public function showLoginForm()
	{
		echo '	<div id="login">
					<form id="login-form" class="form-inline">
						<input name="username" type="text" id="login-username" placeholder="Username" class="form-control input-sm" id="usr">
						<input name="password" type="password" id="login-password" placeholder="Password" class="form-control input-sm" id="pwd">
						<button id="login-button" class="btn btn-success btn-sm">Login</button>
						</form>
					<button id="register-button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#register-modal">Register</button>
				</div>';
	}

	// show the FAQs
	public function showFAQ($faq_array)
	{
		if ( is_array($faq_array) )
		{
			echo '<div class="panel-group" id="accordion">';

			$i = 0;

			foreach ($faq_array as $faq)
			{
				$i++;

				echo '<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $i . '">' . $faq['question'] . '</a>
							</h4>
						</div>
						<div id="collapse' . $i . '" class="panel-collapse collapse">
							<div class="panel-body">
								' . $faq['answer'] . '
							</div>
						</div>
					</div>';
			}

			echo '</div>';

			return true;
		}

		return false;
	}

	public function showEditFAQForm($faq_array)
	{
		if ( $this->user_handler->isAdmin() == false )
		{
			return false;
			exit();
		}

		if ( is_array($faq_array) )
		{
			foreach ($faq_array as $faq)
			{
				echo '<form class="faq-form" role="form">';

				echo '	<div class="form-group">
							<label class="col-sm-2" for="faq-question">Question:</label>
							<input type="text" class="col-sm-10" id="faq-question" name="faq-question" value="' . $faq['question'] . '">
						</div>';

				echo '	<div class="form-group">
							<label class="col-sm-2" for="faq-answer">Answer:</label>
							<textarea class="col-sm-10" id="faq-answer" name="faq-answer">' . $faq['answer'] . '</textarea>
						</div>';

				echo '	<div class="form-group">
							<label class="col-sm-2" for="faq-delete">Delete?</label>
							<input class="col-sm-10" type="checkbox" id="faq-delete" name="faq-delete">
						</div>';

				echo '<input type="number" id="faq-id" name="faq-id" value="' . $faq['id'] . '" hidden>';

				echo '<button type="submit">Edit</button>';

				echo '</form>';
			}


			return true;
		}

		return false;
	}

	public function showNewFAQForm()
	{
		echo '<form class="new-faq-form" role="form">';

		echo '	<div class="form-group">
					<label class="col-sm-2" for="new-faq-question">Question:</label>
					<input type="text" class="col-sm-10" id="new-faq-question" name="new-faq-question" value="">
				</div>';

		echo '	<div class="form-group">
					<label class="col-sm-2" for="new-faq-answer">Answer:</label>
					<textarea class="col-sm-10" id="new-faq-answer" name="new-faq-answer"></textarea>
				</div>';

		echo '<button type="submit">Create</button>';

		echo '</form>';
	}

	// show the new users today list elements in adminpanel overview
	public function showNewUsers($new_users)
	{
		if ( is_array($new_users) )
		{
			foreach ($new_users as $new_user)
			{
				echo '<li class="list-group-item list-group-item-info"><a href="user.php?id=' . $new_user['id'] . '">'. $new_user['username'] . '</a></li>';
			}

			return true;
		}

		return false;
	}

	// show the complete userlist for the adminpanel
	public function showUserlist($users)
	{

		if ( is_array($users) )
		{
			// print the table container
			echo '<table class="table table-bordered table-striped">';

			// print the table header
			echo '<thead>
					<tr>
						<th>
							Username
						</th>
						<th>
							Email
						</th>
						<th>
							First Name
						</th>
						<th>
							Last Name
						</th>
						<th>
							Active
						</th>
						<th>
							Admin
						</th>
						<th>
							Edit
						</th>
					</tr>
				</thead>';

			// print the table body container
			echo '<tbody>';

			// iterate user data
			foreach ($users as $user)
			{
				echo '<tr>';
				echo '	<td>' . $user['username'] . '</td>
						<td>' . $user['email'] . '</td>
						<td>' . $user['prename'] . '</td>
						<td>' . $user['lastname'] . '</td>
						<td>' . $user['active'] . '</td>
						<td>' . $user['admin'] . '</td>
						<td><a href="user.php?id=' . $user['id'] . '"><strong>edit</strong></a></td>';
				echo '</tr>';
			}

			// print the end of table body container
			echo '</tbody>';
			// and the end of the table
			echo '</table>';
		}
		else
		{
			throw new Exception("Input must be an array.", 1);
			return false;
		}		
	}

	public function showTicketForm($to_uid, $ticket_id, $from_uid = false)
	{
		echo '<form class="form-horizontal" id="ticket-form" role="form">';

		if ( $from_uid != false)
		{
			echo '<input id="from-ticket-form" name="from-ticket-form" value="' . $from_uid . '" hidden>';
		}
		else
		{
			echo '<input id="from-ticket-form" name="from-ticket-form" value="' . $_SESSION['uid'] . '" hidden>';
		}

		echo '<input id="id-ticket-form" name="id-ticket-form" value="' . $ticket_id . '" hidden>';
		echo '<input id="to-ticket-form" name="to-ticket-form" value="' . $to_uid . '" hidden>';

		// that part of the form which is visible to user
		echo '	<div class="form-group">
					<label class="col-sm-2" for="subject-ticket-form">Subject:</label>
					<input class="col-sm-10" id="subject-ticket-form" name="subject-ticket-form">
				</div>';

		echo '	<div class="form-group">
					<label class="col-sm-2" for="body-ticket-form">Message:</label>
					<textarea class="col-sm-10" id="body-ticket-form" name="body-ticket-form" rows="10"></textarea>
				</div>';

		echo '<button id="ticket-form-submit" role="submit">Submit</button>';

		echo '</form>';
	}

	public function showTickets($tickets)
	{
		if ( is_array($tickets) )
		{
			echo '<div class="row">';

			foreach ($tickets as $ticket) 
			{
				echo '<div class="col-xs-12">';

				$this->showTicket($ticket);

				echo '</div>';	
			}

			echo '</div>';
			echo '<hr>';
		}
	}

	public function showTicket($ticket)
	{
		$is_admin = $this->user_handler->isAdmin();

		if ( $ticket['from_uid'] == $_SESSION['uid'] )
		{
			echo '<div class="ticket ticket-you bg-info">';

			echo '<p><strong>From:</strong> You</p>';

			if ( $is_admin )
			{
				$to_username = $this->user_handler->getUsernameById($ticket['to_uid']);
			}
			else
			{
				$to_username = 'Support';
			}
			
			echo '<p><strong>To:</strong> ' . $to_username . '</p>';
		}
		elseif ( $ticket['to_uid'] == $_SESSION['uid'] )
		{
			echo '<div class="ticket ticket-from bg-danger">';

			if ( $is_admin )
			{
				$from_username = $this->user_handler->getUsernameById($ticket['from_uid']);
			}
			else
			{
				$from_username = 'Support';
			}


			echo '<p><strong>From:</strong> ' . $from_username . ' </p>';

			echo '<p><strong>To:</strong> You</p>';
		}
		/*else
		{
			exit();
		}*/

		echo '<p><strong>Subject:</strong> ' . $ticket['subject'] . '</p>';
		echo '<p>' . nl2br($ticket['body']) . '</p>';



		echo '</div>';
	}

	public function showTicketList($tickets)
	{
		if ( is_array($tickets) )
		{
			foreach ($tickets as $ticket)
			{
				$username = $this->user_handler->getUsernameById($ticket['from_uid']);
				$uid = $ticket['from_uid'];
				$ticket_id = $ticket['id'];

				echo '<div class="ticket-container">';

				echo '<p><a href="ticket.php?uid=' . $uid . '&ticket_id=' . $ticket_id . '">' . $ticket_id . '</a> - <a href="user.php?id=' . $uid . '">' . $username . '</a></p>';

				echo '</div>';
			}
		}
	}

	public function showContactForm()
	{
		echo 'replace me with contact form';
	}

	public function showChangePasswordAlert()
	{
		echo '	<div class="alert alert-danger">
					<strong>Danger!</strong> The standard-password is set and thats a big security issue. Please change your password.
				</div>';
	}

	// show the impressum
	public function showImpress()
	{
		$impress = nl2br($this->config->shop_impress);
		echo $impress;
	}

	// strip non alphanumeric characters in a given string and then return this string
	public function stripNonAlphaNumeric($string)
	{
		return preg_replace('/[^a-z0-9 ]/i', '', $string);
	}
}

?>