<script type="text/javascript">
	
	$(document).on('click', '.accordion-toggle', function(){
		var visible = $(this).children('div').hasClass('glyphicon-chevron-down');

		if ( ! visible)
			$(this).children('div').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		else
			$(this).children('div').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	});

	$(document).on('change', '.js-inherited-roles', function(){
		var parentStatus = $(this).is(':checked');

		$.ajax({
			type: "POST",
			url: "{{ URL::to('ajax/info/role_inherited_tasks') }}",
			data: { role: $(this).data('role') },
			dataType: 'json',
			beforeSend: function(){
				// Block the UI so they know what's going on
				$.blockUI({
					message: "<span class='text-small'>{{ lang('short.roles.inheritedTaskProcessing') }}</span>",
					css: {
						padding: '5px',
						border: 'none',
						color: '#444',
						'border-radius': '4px',
						'font-weight': '600',
						'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)'
					}
				});
			},
			success: function(data){
				$.each(data, function(){
					var check = $('.taskList input:checkbox[value=' + JSON.stringify(this) + ']');

					if (parentStatus)
					{
						if ( ! check.prop("checked") && ! check.prop("disabled"))
							check.prop("checked", true).prop("disabled", true);
					}
					else
					{
						//
					}
				});

				// Unblock the UI
				$.unblockUI();
			}
		});
	});

	$(document).on('click', '.js-role-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('<div/>').dialog2({
				title: "{{ ucwords(lang('short.delete', lang('role'))) }}",
				content: "{{ URL::to('ajax/delete/role') }}/" + id
			});
		}

		if (doaction == 'duplicate')
		{
			$('#duplicateRole').modal({
				remote: "{{ URL::to('ajax/add/role_duplicate') }}/" + id
			}).modal('show');
		}

		if (doaction == 'view')
		{
			$('#usersWithRole').modal({
				remote: "{{ URL::to('ajax/info/users_with_role') }}/" + id
			}).modal('show');
		}

		return false;
	});

</script>