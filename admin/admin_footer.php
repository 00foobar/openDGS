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



	<!-- Bootstrap Core JavaScript -->
	<script src="../js/bootstrap.min.js"></script>



	<!-- Logout JS -->
	<script type="text/javascript">

		$( document ).ready(function()
		{
			// JS part for the logout
			$('#logout-button').click( function()
			{
				$.get('../logout.php', function()
				{
					location.reload(true);
				});
			});

		});

	</script>

	<script type="text/javascript">
		$( document ).ready(function()
		{
			$('#settings-form').submit(function(event)
			{
				event.preventDefault();

				if ( $('#settings-form').valid() )
				{

					var user_min = $('#user_min').val();
					var user_max = $('#user_max').val();
					var pass_min = $('#pass_min').val();
					var pass_max = $('#pass_max').val();
					var shop_url = $('#shop_url').val();
					var shop_name = $('#shop_name').val();
					var shop_currency = $('#shop_currency').val();
					var shop_percentfee = $('#shop_percentfee').val();
					var shop_articlepp = $('#shop_articlepp').val();
					var shop_impress = $('#shop_impress').val();
					var shop_copyright = $('#shop_copyright').val();

					$.post( 'actions.php', { user_min: user_min, user_max: user_max, pass_min: pass_min, pass_max: pass_max, shop_url: shop_url, shop_name: shop_name, shop_currency: shop_currency, shop_percentfee: shop_percentfee, shop_articlepp: shop_articlepp, shop_impress: shop_impress, shop_copyright: shop_copyright }, function( data )
					{
						if ( data == true )
						{
							// successfull
							alert('yes, sir.');
						}
						else
						{
							// failed
							alert('no, sir.');
						}
					}, 'json');

				}

			});

		});

	</script>
</body>

</html>