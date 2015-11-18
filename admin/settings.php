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
						General Settings
					</h1>
				</div>					
					
				<br>

				<div class="row">
					<div class="col-xs-12 settings-menu">
						<ul class="nav nav-tabs nav-justified settings-menu">
							<li class="active"><a href="#">Shop</a></li>
							<li><a href="#">User</a></li>
							<li><a href="#">Legal texts</a></li>
							<li><a href="#">Security/Anonymity</a></li>
						</ul>
					</div>
				</div>


					<div class="well">

						<div class="row">
							<div class="col-xs-12 user-settings-body">
					
								<form id="settings-form" role="form">
									<h3><strong>User</strong></h3>
									<br>
									<div class="form-group">
										<label for="user_min">Minimum username length:</label>
										<input type="number" class="form-control" id="user_min" name="user_min" value="<?php echo $config_array['user_min']; ?>">
									</div>

									<div class="form-group">
										<label for="user_max">Maximum username length:</label>
										<input type="number" class="form-control" id="user_max" name="user_max" value="<?php echo $config_array['user_max']; ?>">
									</div>

									<div class="form-group">
										<label for="pass_min">Minimum password length:</label>
										<input type="number" class="form-control" id="pass_min" name="pass_min" value="<?php echo $config_array['pass_min']; ?>">
									</div>

									<div class="form-group">
										<label for="pass_max">Maximum password length:</label>
										<input type="number" class="form-control" id="pass_max" name="pass_max" value="<?php echo $config_array['pass_max']; ?>">
									</div>

									<br>
									<h3><strong>Shop</strong></h3>
									<br>

									<div class="form-group">
										<label for="shop_url">Shop-URL:</label>
										<input type="text" class="form-control" id="shop_url" name="shop_url" value="<?php echo $config_array['shop_url']; ?>">
									</div>

									<div class="form-group">
										<label for="shop_name">Shop name:</label>
										<input type="text" class="form-control" id="shop_name" name="shop_name" value="<?php echo $config_array['shop_name']; ?>">
									</div>

									<div class="form-group">
										<label for="shop_currency">Currency:</label>
										<input type="text" class="form-control" id="shop_currency" name="shop_currency" value="<?php echo $config_array['shop_currency']; ?>">
									</div>

									<div class="form-group">
										<label for="shop_percentfee">Percent fee:</label>
										<input type="number" class="form-control" id="shop_percentfee" name="shop_percentfee" value="<?php echo $config_array['shop_percentfee']; ?>">
									</div>

									<div class="form-group">
										<label for="shop_articlepp">Maximum articles per page:</label>
										<input type="number" class="form-control" id="shop_articlepp" name="shop_articlepp" value="<?php echo $config_array['shop_articlepp']; ?>">
									</div>

									<br>
									<h3><strong>Conditions / Impressum</strong></h3>
									<br>

									<div class="form-group">
										<label for="shop_impress">Impressum:</label>
										<textarea class="form-control" id="shop_impress" name="shop_impress"><?php echo $config_array['shop_impress']; ?></textarea>
									</div>

									<div class="form-group">
										<label for="shop_copyright">Copyright note:</label>
										<textarea class="form-control" id="shop_copyright" name="shop_copyright"><?php echo $config_array['shop_copyright']; ?></textarea>
									</div>

									<br>

									<button type="submit" class="btn btn-success">Submit</button>
								</form>

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