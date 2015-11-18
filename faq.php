<?php
include('header.php');

$faq_handler = new FAQ();
$view = new View();

$faq = $faq_handler->getFAQ();
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

<div class="faq-container">
  <h1>FAQ</h1>
  <p></p>

  <?php
  	$view->showFAQ($faq);
  ?>
</div>

		</div>
	</div>
</div>

<?php
include('footer.php');
?>
