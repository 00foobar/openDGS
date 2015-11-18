<?php
	include('header.php');

	// checks if user is logged
	if ( !$user->isLoggedIn() )
	{
		// user is no admin or not logged in
		exit();
	}

	// initialize the product class
	$products = new Product();

	// get the product data
	$product = $products->getProductById(intval($_GET['id']));
?>

<!-- content wrapper -->
<div class="container-full">

	<!-- page row -->
	<div class="row"> 

		<!-- sidebar -->
		<div class="col-sm-2 sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="sidebar-brand">
					<a href="#">
						Categories
					</a>
				</li>
					<!-- shows the categories as list elements -->
					<?php
						$view->showCategories();
					?>
			</ul>
		</div> <!-- /.sidebar -->

		<!-- content -->
		<div class="col-sm-10">

			<!-- category title -->
			<div class="row">
				<div id="product-list-header" class="col-xs-12">
					<h1>
						Cart
					</h1>
				</div>

				<div class="col-xs-12">
					
					<div class="row cart-header bg-danger">

						<div class="hidden-xs col-sm-3">
							<p>Image</p>
						</div>

						<div class="col-xs-6">
							<p>Article</p>
						</div>

						<div class="col-xs-1">
							<p>Quantity</p>
						</div>

						<div class="col-xs-2 text-right">
							<p>Total(s)</p>
						</div>

					</div>

					<div class="row cart-header">
						
						<div class="hidden-xs col-sm-3">
							<img src="<?php echo $product['image_url']; ?>" class="img-responsive">
						</div>

						<div class="col-xs-6">
							<p><?php echo $product['name']; ?></p>
							<p><?php echo  number_format($product['price'], 2) . ' ' . $config->shop_currency; ?></p>
						</div>

						<div class="col-xs-1">
							<p>1</p>
						</div>

						<div class="col-xs-2 text-right">
							<p><?php echo number_format($product['price'], 2) . ' ' . $config->shop_currency; ?></p>
						</div>

					</div>

					<div class="row cart-header bg-danger">

						<div class="hidden-xs col-sm-3">

						</div>

						<div class="col-xs-6">

						</div>

						<div class="col-xs-1">
							<p>Quantity</p>
						</div>

						<div class="col-xs-2 text-right">
							<p>Total(s)</p>
						</div>

					</div>

					<div class="row cart-header">

						<div class="hidden-xs col-sm-3">

						</div>

						<div class="col-xs-6">

						</div>

						<div class="col-xs-1">
							<p>Tax <strong>19%</strong></p>
						</div>

						<div class="col-xs-2 text-right">
							<p><strong><?php echo number_format(($product['price'] / 100) * 19, 2) . ' ' . $config->shop_currency; ?></strong></p>
						</div>

					</div>

					<div class="row cart-header">

						<div class="hidden-xs col-sm-3">

						</div>

						<div class="col-xs-6">

						</div>

						<div class="col-xs-1">
							<p><strong>Total</strong></p>
						</div>

						<div class="col-xs-2 text-right">
							<p><strong><?php echo number_format($product['price'], 2) . ' ' . $config->shop_currency; ?></strong></p>
						</div>

					</div>

				</div>
			</div> <!-- /.category title -->
			
			<br><br>

			<!-- content wrapper -->
			<div class="row cart-header">
				<div class="col-xs-6">
						<div class="form-group">
							<label for="payment-method">How to pay?</label>
							<select class="form-control" id="payment-method">
								<option>Bitcoin</option>
								<option>PayPal</option>
							</select>
						</div>
				</div>

				<div class="col-xs-6 text-right">
					<br>
					<button class="btn btn-lg btn-success">Buy</button>
				</div>
					<?php
						// $view->showCheckoutButton();
					?>
			</div> <!-- /.content wrapper -->

		</div> <!-- /.content -->

	</div> <!-- /.page row -->

	<script type="text/javascript">
		/* CHECKOUT JS */
	</script>

<?php
	include('footer.php');
?>