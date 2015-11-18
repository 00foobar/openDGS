// JS part for the login 

	$( document ).ready(function()
	{

		// JS part for the desktop login
		$('#login-form').submit(function(event)
		{
			event.preventDefault();

			var user = $('#login-username').val();
			var pass = $('#login-password').val();

			$.post( 'controller/login.php', { username: user, password: pass }, function( data )
			{
				// was login successfull?
				if ( data == true )
				{

					// login successfull
					location.reload(true);
				}
				else
				{
					// login failed
					$('#login-failed-modal').modal();
					$('#login-failed-modal').modal('show'); 
				}
			}, 'json');
		});

		// JS part for the mobile-login (modal)
		$('#mobile-login-form').submit(function(event)
		{
			event.preventDefault();

			var user = $('#mobile-login-username').val();
			var pass = $('#mobile-login-password').val();

			$.post( 'controller/login.php', { username: user, password: pass }, function( data )
			{
				// was login successfull?
				if ( data == true )
				{

					// login successfull
					location.reload(true);
				}
				else
				{
					// login failed
					$('#login-failed-modal').modal();
					$('#login-failed-modal').modal('show'); 
				}
			}, 'json');
		});

		// JS part for the logout
		$('#logout-button').click( function()
		{
			$.get('controller/logout.php', function()
			{
				location.reload(true);
			});
		});

	});