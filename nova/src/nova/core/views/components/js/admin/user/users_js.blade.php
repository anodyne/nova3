<script type="text/javascript">
	
	var delay = (function()
	{
		var timer = 0;
		
		return function(callback, ms)
		{
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$(document).on('keyup', '#user-search', function(e)
	{
		delay(function()
		{
			$.ajax({
				beforeSend: function(){
					$('#no-results').addClass('hide');
					$('#results').addClass('hide');
					
					$('#results-name').addClass('hide');
					$('#results-name dl dd').remove();
					
					$('#results-email').addClass('hide');
					$('#results-email dl dd').remove();
					
					$('#results-characters').addClass('hide');
					$('#results-characters dl dd').remove();

					$('#activeUsers').addClass('hide');
					$('#allUsers').removeClass('hide');

					$('#searchComplete').addClass('hide');
					$('#searching').removeClass('hide');
				},
				url: '{{ URL::to("ajax/get/user_search") }}',
				type: 'POST',
				dataType: 'json',
				data: { query: $('#user-search').val() },
				success: function(data)
				{
					// Build the URL ahead of time
					var url = '{{ URL::to("admin/user/edit") }}/';
					
					if ( ! $.isEmptyObject(data.name))
					{
						$.each(data.name, function(key, value)
						{
							console.log(key);
							console.log(value);
							$('#results-name dl').append('<dd><a href="' + url + value.id + '" class="btn btn-small btn-default icn-size-16">{{ $_icons["edit"] }}</a>&nbsp;&nbsp;' + value.name + '</dd>');
						});
						
						$('#results-name').removeClass('hide');
					}
					
					if ( ! $.isEmptyObject(data.email))
					{
						$.each(data.email, function(key, value)
						{
							$('#results-email dl').append('<dd><a href="' + url + value.id + '" class="btn btn-small btn-default icn-size-16">{{ $_icons["edit"] }}</a>&nbsp;&nbsp;' + value.name + ' (' + value.email + ')' + '</dd>');
						});
						
						$('#results-email').removeClass('hide');
					}
					
					if ( ! $.isEmptyObject(data.characters))
					{
						$.each(data.characters, function(key, value)
						{
							$('#results-characters dl').append('<dd><a href="' + url + value.id + '" class="btn btn-small btn-default icn-size-16">{{ $_icons["edit"] }}</a>&nbsp;&nbsp;' + value.name + ' (' + value.first_name + ' ' + value.last_name + ')' + '</dd>');
						});
						
						$('#results-characters').removeClass('hide');
					}
					
					if ($.isEmptyObject(data.name) && $.isEmptyObject(data.email) 
							&& $.isEmptyObject(data.characters))
					{
						$('#no-results').removeClass('hide');
					}
					else
					{
						$('#results').removeClass('hide');
					}
				}
			});
		}, 500);
	});

	$(document).on('click', '[rel="changeUserView"]', function(e)
	{
		// Get the view
		var view = $(this).attr('id');

		// Clear the search field
		$('#user-search').val('').text('');
		
		if (view == 'showAll')
		{
			$('#activeUsers').addClass('hide');
			$('#allUsers').removeClass('hide');
		}
		else
		{
			$('#activeUsers').removeClass('hide');
			$('#allUsers').addClass('hide');
		}

		$('#searchComplete').addClass('hide');
		
		e.preventDefault();
	});
	
	$(document).on('click', '.js-user-action', function(e)
	{
		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteUser').modal({
				remote: "{{ URL::to('ajax/delete/user') }}/" + id
			}).modal('show');
		}

		if (action == 'link')
		{
			$('#linkUser').modal({
				remote: "{{ URL::to('ajax/update/link_to_user') }}/" + id
			}).modal('show');
		}

		e.preventDefault();
	});

	$(document).ajaxStop(function()
	{
		if ($('#allUsers').is(':visible'))
		{
			$('#searching').addClass('hide');
			$('#searchComplete').removeClass('hide');
		}
	});

</script>