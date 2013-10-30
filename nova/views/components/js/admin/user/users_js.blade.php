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
					$('#no-results').addClass('hidden');
					$('#results').addClass('hidden');
					
					$('#results-name').addClass('hidden');
					$('#results-name dl dd').remove();
					
					$('#results-email').addClass('hidden');
					$('#results-email dl dd').remove();
					
					$('#results-characters').addClass('hidden');
					$('#results-characters dl dd').remove();

					$('#activeUsers').addClass('hidden');
					$('#allUsers').removeClass('hidden');

					$('#searchComplete').addClass('hidden');
					$('#searching').removeClass('hidden');
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
							$('#results-name dl').append('<dd><a href="' + url + value.id + '" class="btn btn-sm btn-default icn-size-16">{{ $_icons["edit"] }}</a>&nbsp;&nbsp;' + value.name + '</dd>');
						});
						
						$('#results-name').removeClass('hidden');
					}
					
					if ( ! $.isEmptyObject(data.email))
					{
						$.each(data.email, function(key, value)
						{
							$('#results-email dl').append('<dd><a href="' + url + value.id + '" class="btn btn-sm btn-default icn-size-16">{{ $_icons["edit"] }}</a>&nbsp;&nbsp;' + value.name + ' (' + value.email + ')' + '</dd>');
						});
						
						$('#results-email').removeClass('hidden');
					}
					
					if ( ! $.isEmptyObject(data.characters))
					{
						$.each(data.characters, function(key, value)
						{
							$('#results-characters dl').append('<dd><a href="' + url + value.id + '" class="btn btn-sm btn-default icn-size-16">{{ $_icons["edit"] }}</a>&nbsp;&nbsp;' + value.name + ' (' + value.first_name + ' ' + value.last_name + ')' + '</dd>');
						});
						
						$('#results-characters').removeClass('hidden');
					}
					
					if ($.isEmptyObject(data.name) && $.isEmptyObject(data.email) 
							&& $.isEmptyObject(data.characters))
					{
						$('#no-results').removeClass('hidden');
					}
					else
					{
						$('#results').removeClass('hidden');
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
			$('#activeUsers').addClass('hidden');
			$('#allUsers').removeClass('hidden');
		}
		else
		{
			$('#activeUsers').removeClass('hidden');
			$('#allUsers').addClass('hidden');
		}

		$('#searchComplete').addClass('hidden');
		
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
			$('#searching').addClass('hidden');
			$('#searchComplete').removeClass('hidden');
		}
	});

</script>