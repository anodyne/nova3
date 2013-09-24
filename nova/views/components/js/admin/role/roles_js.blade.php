<script type="text/javascript">
	
	$(document).on('click', '.accordion-toggle', function()
	{
		var visible = $(this).children('div').hasClass('glyphicon-chevron-down');

		if ( ! visible)
			$(this).children('div').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		else
			$(this).children('div').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	});

	$(document).on('change', '.js-inherited-roles', function()
	{
		var parent = $(this);
		var parentStatus = $(this).is(':checked');

		$.ajax({
			type: "POST",
			url: "{{ URL::to('ajax/info/role_inherited_tasks') }}",
			data: {
				role: parent.data('role')
			},
			dataType: 'json',
			beforeSend: function()
			{
				// Block the UI so they know what's going on
				$.blockUI({
					message: "<span class='text-small'>{{ lang('short.admin.roles.inheritedTaskProcessing') }}</span>",
					onBlock: function()
					{ 
						$('.blockPage').addClass('blockUIModal');
					}
				});
			},
			success: function(data)
			{
				$.each(data, function()
				{
					var check = $('.taskList input:checkbox[value=' + JSON.stringify(this) + ']');

					if (parentStatus)
					{
						if ( ! check.prop("checked") && ! check.prop("disabled"))
							check.prop("checked", true).prop("disabled", true);
					}
					else
					{
						if (check.prop("disabled"))
						{
							$.ajax({
								type: "POST",
								url: "{{ URL::to('ajax/info/roles_with_task') }}/" + check.val() + "/json",
								dataType: "json",
								success: function(roles)
								{
									if (roles.length == 1 && roles.id == parent.val())
										check.prop("checked", false).prop("disabled", false);

									if (roles.length > 1)
									{
										// Get an array of all the checked inherited roles
										var checkedValues = $('.js-inherited-roles:checked').map(function()
										{
											return this.value;
										}).get();

										// Are we allowed to clear the task?
										var clearTask = true;

										// Loop through the roles
										$.each(roles, function()
										{
											// Is the role one of the checked roles?
											if ($.inArray(this.id.toString(), checkedValues) > -1 && clearTask == true)
												clearTask = false;
										});

										if (clearTask == true)
											check.prop("checked", false).prop("disabled", false);
									}
								}
							});
						}
					}
				});
			}
		});
	});

	$(document).on('click', '.js-role-action', function(e)
	{
		e.preventDefault();

		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteRole').modal({
				remote: "{{ URL::to('ajax/delete/role') }}/" + id
			}).modal('show');
		}

		if (action == 'duplicate')
		{
			$('#duplicateRole').modal({
				remote: "{{ URL::to('ajax/add/role_duplicate') }}/" + id
			}).modal('show');
		}

		if (action == 'view')
		{
			$('#usersWithRole').modal({
				remote: "{{ URL::to('ajax/get/users_with_role') }}/" + id
			}).modal('show');
		}
	});

	// Unblock the UI only after all the Ajax requests have finished
	$(document).ajaxStop($.unblockUI);

</script>