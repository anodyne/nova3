<script type="text/javascript">
	// change the base preview based on what the user clicks
	$('input[name="base"]').on('change', function(){

		// get the value
		var baseVal = $('input[name="base"]:checked').val();

		// change the base in the preview
		$('#rankPreview div[rel="rankBaseImage"]').css('background-image', 'url(<?php echo Uri::base(false).$rankPath;?>base/' + baseVal + '<?php echo $rankExt;?>)');
	});

	// change the pip preview based on what the user clicks
	$('input[name="pip"]').on('change', function(){

		// get the value
		var pipVal = $('input[name="pip"]:checked').val();

		// change the base in the preview
		$('#rankPreview div[rel="rankPipImage"]').css('background-image', 'url(<?php echo Uri::base(false).$rankPath;?>pips/' + pipVal + '<?php echo $rankExt;?>)');
	});

	// what action to take when a rank group action is clicked
	$('.rank-action').on('click', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('<div/>').dialog2({
				title: "<?php echo ucwords(lang('short.delete', lang('rank')));?>",
				content: "<?php echo Uri::create('ajax/delete/rank');?>/" + id
			});
		}

		return false;
	});

	$(document).ready(function(){

		// show the first tab
		$('.nav-tabs a:first').tab('show');
	});
</script>