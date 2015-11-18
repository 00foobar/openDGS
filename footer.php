	<!-- registration modal -->
	<div id="register-modal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">

			<!-- modal content-->
			<div class="modal-content">
				
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registration</h4>
				</div>
				
				<!-- modal body -->
				<div class="modal-body">
					<p>Some text in the modal.</p>

					<!-- registration form -->
					<form id="registration-form" role="form">

						<div class="form-group">
							<label for="username">Username:</label>
							<input type="text" class="form-control" id="registration-username" name="username" required>
						</div>

						<div class="form-group">
							<label for="username">Prename:</label>
							<input type="text" class="form-control" id="registration-prename" name="prename" required>
						</div>

						<div class="form-group">
							<label for="username">Lastname:</label>
							<input type="text" class="form-control" id="registration-lastname" name="lastname" required>
						</div>

						<div class="form-group">
							<label for="email">E-mail:</label>
							<input type="email" class="form-control" id="registration-email" name="email" required>
						</div>

						<div class="form-group">
							<label for="password">Password:</label>
							<input type="password" class="form-control" id="registration-password" name="password" required>
						</div>

						<div class="form-group">
							<label for="password_repeat">Password (repeat):</label>
							<input type="password" class="form-control" id="registration-password-repeat" name="password_repeat" required>
						</div>

						<div class="checkbox">
							<label><input type="checkbox" id="registration-conditions" name="conditions" value="accepted" required> I read and accepted the <a href="conditions.php">conditions</a>.</label>
						</div>

						<button type="submit" class="btn btn-success">Submit</button>

					</form> <!-- registration form -->

					<div id="registration-error" class="alert alert-danger">
						<strong>Error!</strong>
						<p></p>
					</div>

					<div id="registration-success" class="alert alert-success">
						<strong>Success!</strong>
						<p>You will be redirected in three seconds...</p>
					</div>

				</div> <!-- /.modal body -->
			
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div> <!-- /.modal body -->

			</div> <!-- /.modal content -->
		</div> <!-- /.modal dialog -->
	</div> <!-- /.registration modal -->


	<!-- login-failed modal -->
	<div id="login-failed-modal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">

			<!-- modal content-->
			<div class="modal-content">
				
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Sorry</h4>
				</div>
				
				<!-- modal body -->
				<div class="modal-body">
					<div class="text-center">
						<span style="font-size:5.5em;" class="glyphicon glyphicon-warning-sign"></span>
					</div>
					<p>Your login failed. Do you want to use the password-forget function?</p>
				</div> <!-- /.modal body -->
			
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div> <!-- /.modal body -->

			</div> <!-- /.modal content -->
		</div> <!-- /.modal dialog -->
	</div> <!-- /.login-failed modal -->



	<!-- mobile login modal -->
	<div id="mobile-login-modal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">

			<!-- modal content-->
			<div class="modal-content">
				
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Login</h4>
				</div>
				
				<!-- modal body -->
				<div class="modal-body">

					<!-- login form -->
					<form id="mobile-login-form" role="form">

						<div class="form-group">
							<label for="username">Username:</label>
							<input name="username" type="text" id="mobile-login-username" placeholder="Username" class="form-control input-sm" id="usr">
						</div>

						<div class="form-group">
							<label for="pwd">Password:</label>
							<input name="password" type="password" id="mobile-login-password" placeholder="Password" class="form-control input-sm" id="pwd">
						</div>

						<button id="mobile-login-button" class="btn btn-success btn-sm">Login</button>

					</form> <!-- login form -->

				</div> <!-- /.modal body -->
			
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div> <!-- /.modal body -->

			</div> <!-- /.modal content -->
		</div> <!-- /.modal dialog -->
	</div> <!-- /.mobile login modal -->

		<hr>

		<!-- Footer -->
		<footer>
			<div class="row">
				<div class="col-xs-12 text-center">
					<p><?php echo $config->shop_copyright; ?></p>
				</div>
			</div>
			<!-- /.row -->
		</footer>

	</div>
	<!-- /.container -->

	<!-- jQuery -->
	<script src="js/jquery.js"></script>

	<!-- jQuery.validation -->
	<script src="js/jquery.validate.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>

	<!-- Login/Logout JS -->
	<script src="js/login.js"></script>

	<!-- Registration clientside validation -->
	<script type="text/javascript">
		$( document ).ready(function()
		{
			// validate signup form on keyup and submit
			$("#registration-form").validate({
				rules: {
					username: {
						required: true,
						minlength: <?php echo $config->user_min; ?>,
						maxlength: <?php echo $config->user_max; ?>
					},
					password: {
						required: true,
						minlength: <?php echo $config->pass_min; ?>,
						maxlength: <?php echo $config->pass_max; ?>
					},
					password_repeat: {
						required: true,
						minlength: <?php echo $config->pass_min; ?>,
						maxlength: <?php echo $config->pass_max; ?>,
						equalTo: "#registration-password"
					},
					prename: {
						required: true,
						minlength: 1,
						maxlength: 255
					},
					lastname: {
						required: true,
						minlength: 1,
						maxlength: 255
					},
					email: {
						required: true,
						email: true
					},
					conditions: "required"
				},
				messages: {
					username: {
						required: "Please enter a username.",
						minlength: "Your username must consist of at least " + <?php echo $config->user_min; ?> + " characters.",
						maxlength: "Your username must consist of maximum " + <?php echo $config->user_max; ?> + " characters."
					},
					password: {
						required: "Please provide a password.",
						minlength: "Your password must consist of at least " + <?php echo $config->pass_min; ?> + " characters.",
						maxlength: "Your password must consist of maximum " + <?php echo $config->pass_max; ?> + " characters."
					},
					confirm_password: {
						required: "Please provide a password.",
						minlength: "Your password must consist of at least " + <?php echo $config->pass_min; ?> + " characters.",
						maxlength: "Your password must consist of maximum " + <?php echo $config->pass_max; ?> + " characters.",
						equalTo: "Please enter the same password as above."
					},
					prename: {
						required: "Please provide a prename.",
						minlength: "Your password must consist of at least one characters.",
						maxlength: "Your password must consist of maximum 255 characters."
					},
					lastname: {
						required: "Please provide a lastname.",
						minlength: "Your password must consist of at least one characters.",
						maxlength: "Your password must consist of maximum 255 characters."
					},
					email: "Please enter a valid email address.",
					conditions: "Please accept our policy."
				}
			});

		});
	</script>

	<!-- Registration JS -->
	<script src="js/register.js"></script>

	<!-- Ticket JS -->
	<script src="js/ticket.js"></script>



</body>

</html>