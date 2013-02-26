<script type="text/javascript">
	$(document).ready(function(){
		
		$(document).on('click', '#table', function(){
			var send = {
				table: $('input[name=table_name]').val()
			};
			
			$.ajax({
				beforeSend: function(){
					// show the loader
					$('.loading-table').removeClass('hide');
					$('.database-content .alert-success').addClass('hide');
					$('.database-content .alert-danger').addClass('hide');
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/utilityajax/install_table');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					// hide the loader
					$('.loading-table').addClass('hide');
					
					if (data.code == 1)
						$('.database-content .alert-success').removeClass('hide');
					else
						$('.database-content .alert-danger').removeClass('hide');
				}
			});
			
			return false;
		});
		
		$('select[name=field_type]').change(function(){
			var selected = $('select[name=field_type] option:selected').val();
			
			if (selected == 'VARCHAR')
			{
				$('input[name=field_constraint]')
					.val('100')
					.prop('disabled', false);
				$('input[name=field_default]').val('').prop('disabled', false).focus();
			}
			else if (selected == 'TEXT' || selected == 'LONGTEXT')
			{
				$('input[name=field_constraint]')
					.val('')
					.prop('disabled', true);
				$('input[name=field_default]').val('').prop('disabled', true);
			}
			else if (selected == 'INT')
			{
				$('input[name=field_constraint]')
					.val('5')
					.prop('disabled', false);
				$('input[name=field_default]').val('0').prop('disabled', false).focus();
			}
			else if (selected == 'TINYINT')
			{
				$('input[name=field_constraint]')
					.val('1')
					.prop('disabled', false);
				$('input[name=field_default]').val('0').prop('disabled', false).focus();
			}
			else if (selected == 'BIGINT')
			{
				$('input[name=field_constraint]')
					.val('20')
					.prop('disabled', false);
				$('input[name=field_default]').val('0').prop('disabled', false).focus();
			}
			else if (selected == 'ENUM')
			{
				$('input[name=field_constraint]')
					.val('')
					.prop('disabled', false)
					.focus();
				$('input[name=field_default]').val('').prop('disabled', false);
			}
		});
		
		$(document).on('click', '#field', function(){
			var send = {
				table: $('select[name=table_name] option:selected').val(),
				name: $('input[name=field_name]').val(),
				type: $('select[name=field_type] option:selected').val(),
				constraint: $('input[name=field_constraint]').val(),
				def: $('input[name=field_default]').val()
			};
			
			$.ajax({
				beforeSend: function(){
					// show the loader
					$('.database-content .alert-success').addClass('hide');
					$('.database-content .alert-danger').addClass('hide');
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/utilityajax/install_field');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					if (data.code == 1)
						$('.database-content .alert-success').removeClass('hide');
					else
						$('.database-content .alert-danger').removeClass('hide');
				}
			});
			
			return false;
		});
		
		$(document).on('click', '#query', function(){
			var send = { query: $('textarea[name=query]').val() };
			
			$.ajax({
				beforeSend: function(){
					// show the loader
					$('.loading-query').removeClass('hide');
					$('.database-content .alert-success').addClass('hide');
					$('.database-content .alert-danger').addClass('hide');
					$('.database-content .alert-important').addClass('hide');
					$('.database-content .alert-info').addClass('hide');
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/utilityajax/install_query');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					// hide the loader
					$('.loading-query').addClass('hide');
					
					if (data.code == 0)
						$('.database-content .alert-danger').removeClass('hide');
					else if (data.code == 1)
						$('.database-content .alert-success').removeClass('hide');
					else if (data.code == 2)
						$('.database-content .alert-important').removeClass('hide');
					else if (data.code == 3)
						$('.database-content .alert-info').removeClass('hide');
				}
			});
			
			return false;
		});
	});
</script>