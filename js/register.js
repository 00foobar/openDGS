		$( document ).ready(function()
		{
			
			$('#registration-form').submit(function(event)
			{
				event.preventDefault();

				$('.alert').hide();

				if ( $('#registration-form').valid() )
				{

					var username = $('#registration-username').val();
					var email = $('#registration-email').val();
					var password = $('#registration-password').val();
					var password_repeat = $('#registration-password-repeat').val();
					var conditions = $('#registration-conditions').val();
					var prename = $('#registration-prename').val();
					var lastname = $('#registration-lastname').val();

					$.post( 'controller/register.php', { username: username, email: email, password: password, password_repeat: password_repeat, conditions: conditions, prename: prename, lastname: lastname }, function( data )
					{
						// was login successfull?
						if ( data == true )
						{
							// login successfull
							$('#registration-success').fadeIn();
							
							setTimeout(function()
							{
								location.reload(true);
							}, 3000);
						}
						else
						{
							// login failed
							$('#registration-error > p').text(data);
							$('#registration-error').fadeIn();
						}
					}, 'json');

				}

			});

		});