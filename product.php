<?php
	include('header.php');
	
	// initialize the view class
	$view = new View();

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
						<?php 

						?>
					</h1>
					<p>
					</p>
				</div>
			</div> <!-- /.category title -->
			
			<!-- content wrapper -->
			<div class="row-fluid">
				<?php
					$view->showProduct($product);
				?>
			</div> <!-- /.content wrapper -->

		</div> <!-- /.content -->

	</div> <!-- /.page row -->

<?php
	include('footer.php');
?>