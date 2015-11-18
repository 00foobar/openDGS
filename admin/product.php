<?php
include('admin_header.php');

$view = new View();
$products = new Product();

if ( isset($_GET['edit']) && is_int($_GET['edit']) )
{
	// edit a product
	$pid = $_GET['edit'];
	$product = $products->getProductById($pid);
	$title = 'Edit product #' . $pid;

	echo '<pre>'; print_r($product); echo '</pre>';
}
else
{
	// new product
	$title = 'Create new product';
}




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

			<div class="panel">
				<div class="panel-body">
					<form role="form">
						<h3 class="page-header">
							Shop Settings
						</h3>
						
						<div class="bs-callout bs-callout-info">
							<h4>Widget Settings</h4>
								<p>The Shop widget allows you to sell supplementary items or services through your Active SoftSwitch site. You can charge a single payment for a SIP Phone, or offer a Premium Support service at a fixed monthly cost, for example.</p>
						</div>

						<div class="panel">
							<div class="panel-body">

								<div> 
									<label>Item image</label>          
									<div>
										<img class="img-responsive center-block" src="https://support.apple.com/library/content/dam/edam/applecare/images/en_US/ipad/ipad/ipad_1_wifi_small.png">
										<input type="file">
										<p class="help-block">Upload an image of the item that is for sale.</p>
									</div>    
								</div>

								<div>    
									<label>Item name</label>
									<div>
										<input class="medium form-control">
									</div>
								</div>

								<div>    
									<label>Item price</label>
									<div>
										<input class="medium form-control">
										<p class="help-block">This will be the single payment amount charged for this item.</p>
									</div>

								</div>

								<div>       
									<label>Item description</label>
									<div>
										<textarea class="medium form-control valid" cols="20" data-val="true" data-val-required="The DisplayLabel field is required.">Local Number</textarea>
										<p class="help-block">Enter a description of the item.</p>
									</div>
								</div>
								
								<div> 
									<label>Number of available units</label>          
									<div>
										<div class="input-prepend input-append input-group" data-bind="visible:ItemsAvailable()>=1">
											<span class="add-on input-group-addon btn"> <i class="icon-minus-sign icon-white fa fa-minus-square"></i>  </span>
											<input class="small text-center form-control valid" data-bind="value:ItemsAvailable,attr:{name:'items.Items['+$index()+'].ItemsAvailable'}" style="background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;" type="text">
											<span class="add-on input-group-addon btn"><i class="icon-plus-sign icon-white fa fa-plus-square"></i></span>
										</div>
									</div>
								</div>

								<div>    
									<label>Subscription plan</label>
									<div>
										<select class="medium product-id-list form-control valid" data-val="true" data-val-number="The field Product Id must be a number." data-val-required="The Product Id field is required." id="localnumbersedit_AccountDefaultValues_ProductId" name="localnumbersedit.AccountDefaultValues.ProductId">
											<option value="">-- Please select a product --</option>
											<option value="1767">Calling Card PIN</option>
											<option value="1999">FAX Product</option>
											<option value="1072">Hosted Office Product</option>
											<option value="985">Incoming Numbers</option>
											<option value="1073">Internet Call Company Product</option>
											<option value="1911">IP Authenticated Account</option>
											<option value="1998">IVR Product</option>
											<option selected="selected" value="1559">LocalNumbers</option>
											<option value="2309">zzzPortaTestProduct</option>
										</select>
										<p class="help-block">If the item has an associated monthly cost, this should be identified through the use of a PortaBilling subscription plan.</p>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> <!-- /.content -->
	</div> <!-- /.page row -->

<?php
include('admin_footer.php');
?>