
		$( document ).ready(function()
		{
			// JS part for edit the FAQ entrys
			$('.faq-form').submit(function(event)
			{
				event.preventDefault();

				var faq_id = $(this).find('#faq-id').val();
				var faq_question = $(this).find('#faq-question').val();
				var faq_answer = $(this).find('#faq-answer').val();

				if ( $(this).find('#faq-delete').is(':checked') )
				{
					var faq_delete = "1";
				}
				else
				{
					var faq_delete = "0";
				}
				

				$.post( 'faq_actions.php', { faq_id: faq_id, faq_question: faq_question, faq_answer: faq_answer, faq_delete: faq_delete }, function( data )
				{
					// send ticket successfull?
					if ( data == true )
					{
						// refresh communication
						location.reload(true);
					}
					else
					{
						// send ticket failed
						console.log('FAQ action failed.');
					}
				}, 'json');

			});


			// JS part for new FAQ entry
			$('.new-faq-form').submit(function(event)
			{
				event.preventDefault();

				var new_faq_question = $('#new-faq-question').val();
				var new_faq_answer = $('#new-faq-answer').val();

				$.post( 'faq_actions.php', { new_faq_question: new_faq_question, new_faq_answer: new_faq_answer }, function( data )
				{
					// send ticket successfull?
					if ( data == true )
					{
						// refresh communication
						location.reload(true);
					}
					else
					{
						// send ticket failed
						console.log('FAQ action failed.');
					}
				}, 'json');

			});

		});