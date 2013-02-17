<script type="text/javascript">
	$(document).ready(function(){

		// set up the fancy choose box
		$('.chzn').chosen();

		<?php if ($type == 'dept'): ?>

			// show the department field
			$('#deptRule').show();
		<?php endif;?>
	});

	$('#ruleType').on('change', function(){

		// get what's selected
		var selected = $('#ruleType option:selected').val();

		if (selected == 'dept')
		{
			// show the div
			$('#deptRule').show();
		}
		else
		{
			// reset the field
			$('[name="condition"]').val('');

			// hide the div
			$('#deptRule').hide();
		}
	});

	// what action to take when a value action is clicked
	$('.apprule-action').on('click', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('<div/>').dialog2({
				title: "<?php echo ucwords(lang('short.delete', langConcat('application rule')));?>",
				content: "<?php echo Uri::create('ajax/delete/apprule');?>/" + id
			});
		}

		return false;
	});
</script>