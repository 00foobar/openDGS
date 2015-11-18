<?php
include('admin_header.php');

$view = new View();
$user = new User();
$pagination = new Pagination();

// get the actual pagenumber (for pagination)
if ( isset($_GET['page']) ) $page = intval($_GET['page']);
else $page = 1;

// config pagination class
$pagination->setTable('users');
$pagination->setPageLink('users.php');
$pagination->setLimit(10);
$pagination->setPage($page);
$pagination->setTotal();
$pagination->setPages();
$pagination->setOffset();

// get the users data as array (for view)
$users = $pagination->getData();
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

			<div class="row users-heading-row">
				<div class="col-xs-12">
					<h1>Users</h1>
				</div>
			</div>

			<div class="row users-table-row">
				<div class="col-xs-12 table-responsive">
					<?php
						$view->showUserlist($users);
					?>
				</div>
			</div>

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

<?php
include('admin_footer.php');
?>