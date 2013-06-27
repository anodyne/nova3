<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		// Activate the first tab
		$('.nav-tabs a:first').tab('show');

		// Set the HTML class
		$('[name="html_class"]').val('col-lg-4');

		// This fixes the issue where the row being dragged is compacted.
		var fixHelper = function(e, ui){
			ui.children().each(function(){
				$(this).width($(this).width());
			});
			
			return ui;
		};

		// Makes the field list sortable and updates when the sort stops
		$('.sort-field tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				$.ajax({
					type: 'POST',
					url: "{{ URL::to('ajax/update/form_field_order') }}",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// Makes the value list sortable and updates when the sort stops
		$('.sort-value tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				$.ajax({
					type: 'POST',
					url: "{{ URL::to('ajax/update/form_value/order') }}",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// Determine the actions when the type dropdown changes
		$('[name="type"]').change(function(){
			var type = $('[name="type"] option:selected').val();
			
			if (type == 'text')
			{
				$('.field-rows').addClass('hide');
				$('.field-placeholder').removeClass('hide');
				$('.field-value').removeClass('hide');
				$('[name="html_class"]').val('col-lg-4');
			}

			if (type == 'textarea')
			{
				$('.field-rows').removeClass('hide');
				$('.field-placeholder').removeClass('hide');
				$('.field-value').removeClass('hide');
				$('[name="html_class"]').val('col-lg-8');
			}

			if (type == 'select')
			{
				$('.field-rows').addClass('hide');
				$('.field-placeholder').addClass('hide');
				$('.field-value').addClass('hide');
				$('[name="html_class"]').val('col-lg-4');
			}
		});
	});

	// What action to take when a field action is clicked
	$(document).on('click', '.js-field-action', function(e){
		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			//
		}

		e.preventDefault();
	});

	// What action to take when a value action is clicked
	$(document).on('click', '.js-value-action', function(e){
		var action = $(this).data('action');
		var parent = $(this).closest('tr');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$.ajax({
				type: 'POST',
				url: "{{ URL::to('ajax/delete/form_value') }}",
				data: { id: id },
				success: function(){
					parent.fadeOut();
				}
			});
		}

		if (action == 'update')
		{
			$.ajax({
				type: 'POST',
				url: "{{ URL::to('ajax/update/form_value/value') }}",
				data: {
					id: id,
					value: $(this).closest('input[type=text]').val()
				},
				beforeSend: function(){
					// Block the UI so they know what's going on
					$.blockUI({
						message: "<span class='text-small'>{{ lang('Action.processing') }}</span>",
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
				success: function(){
					$.unblockUI;
				}
			});
		}

		if (action == 'add')
		{
			var send = {
				content: $('[name="value-add-content"]').val(),
				field: '{{ Request::segment(5) }}'
			}

			if ($('.sort-value tbody tr').length == 1 && $('.sort-value tbody tr:nth-child(1) td').length == 1)
			{
				// There are no values in the database
				send.order = 1;
			}
			else if ($('.sort-value tbody tr').length == 1 && $('.sort-value tbody tr:nth-child(1) td').length > 1)
			{
				// There is already 1 value in the database
				send.order = 2;
			}
			else
			{
				// There's more than 1 value in the database
				send.order = $('.sort-value tbody tr').length + 1;
			}

			$.ajax({
				type: 'POST',
				url: "{{ URL::to('ajax/add/form_value') }}",
				data: send,
				dataType: 'html',
				success: function(data){

					if ($('.sort-value tbody tr').length == 1 && $('.sort-value tbody tr:nth-child(1) td').length == 1)
					{
						// if there's only 1 record AND only one column in the row, replace everything
						$('.sort-value .sort-body').html(data);
					}
					else
					{
						// all other times, we'll append to the end of the table
						$('.sort-value .sort-body').append(data);
					}

					// finally, reset the add field to be blank
					$('[name="value-add-content"]').val('');
				}
			});
		}

		e.preventDefault();
	});
</script>