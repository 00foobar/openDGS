<?php
include('admin_header.php');

$view = new View();
$user = new User();
$faq = new FAQ();

$faq_array = $faq->getFAQ();
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
						Admin
					</a>
				</li>
				<!-- shows the categories as list elements -->
				<?php
					$view->showAdminMenu();
				?>
			</ul>
		</div> <!-- /.sidebar -->

		<!-- content -->
		<div class="col-sm-10">

			<div class="row">

				<div class="col-xs-12">
					<h1>Edit FAQ</h1>
					<div class="well">
						<?php
							$view->showNewFAQForm();
						?>
						<br>
						<hr>
						<br>
						<?php
							$view->showEditFAQForm(array_reverse($faq_array));
						?>
					</div>
				</div>

			</div>

		</div> <!-- /.content -->
	</div> <!-- /.page row -->

	<script src="js/faq.js"></script>


<?php
include('admin_footer.php');
?>