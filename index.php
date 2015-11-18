<?php 
include('header.php');

// set the category from user input (GET)
if ( isset($_GET['category']) ) $category = $_GET['category'];
else $category = null;

// initialize the view class
$view = new View();
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
							if ( !empty($category) ) echo $view->stripNonAlphaNumeric($category);
							else echo 'All categories';
						?>
					</h1>
				</div>
			</div> <!-- /.category title -->
			
			<!-- content wrapper -->
			<div class="row-fluid">
				<?php
					//$view->showProducts($category);
					if ( isset($_GET['page']) ) $page = intval($_GET['page']);
					else $page = 1;

					$pagination = new Pagination();

					$pagination->setTable('products');
					if ( $category != null ) $pagination->setCategory($category);
					$pagination->setLimit($config->shop_articlepp);
					$pagination->setPage($page);

					//$pagination->setCategory('books');

					$pagination->setTotal();
					$pagination->setPages();
					$pagination->setOffset();
					$products = $pagination->getData();
					
					$view->showProducts($products);
				?>
			</div> <!-- /.content wrapper -->


			<!-- pagination -->
			<div class="row text-center">

				<div class="col-lg-12">
					<?php
						$pagination->showPagination();
					?>
				</div>

			</div> <!-- /.pagination -->

		</div> <!-- /.content -->

	</div> <!-- /.page row -->

	<!-- include the footer -->
	<?php include('footer.php'); ?>