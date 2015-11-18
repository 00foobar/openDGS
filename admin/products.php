<?php
include('admin_header.php');

$view = new View();

$config = new Config();
$config_array = $config->getConfigArray();
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

			<div class="row overview-row">

				<div class="col-xs-12">
					<h1>
						Products
					</h1>
				</div>					
					
				<br>

				<div class="row">
					<div class="col-xs-12 settings-menu">
						<ul class="nav nav-tabs nav-justified settings-menu">
							<li class="active"><a href="#">Overview</a></li>
							<li><a href="#">Edit Products (list)</a></li>
							<li><a href="#">New product</a></li>
						</ul>
					</div>
				</div>


					<div class="well">

						<div class="row">
							<div class="col-xs-12 user-settings-body">
								
								<div>
									<p><strong>most buyed products</strong></p>
									<p>today: </p>
									<p>all time: </p>
								</div>

								<div>
									<p>newest products</p>
								</div>	

							</div>
						</div>
					</div>
				</div>

			</div>

		</div> <!-- /.content -->
	</div> <!-- /.page row -->



<?php
include('admin_footer.php');
?>