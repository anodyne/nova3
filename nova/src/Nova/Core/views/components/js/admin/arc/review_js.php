<script type="text/javascript">
	$(document).ready(function(){

		// show the first tab
		$('.nav-tabs a:first').tab('show');

		// set up the fancy choose box
		$('.chzn').chosen();
	});

	$('#decisionDrop').on('change', function(){

		var selected = $('#decisionDrop option:selected').val();

		if (selected == 'approve')
		{
			$('#approveOptions').show();
			$('#adminResponse [name="message"]').val('<?php echo Model_SiteContent::getContent("accept_message");?>');
		}
		else
		{
			$('#approveOptions').hide();
			$('#adminResponse [name="message"]').val('<?php echo Model_SiteContent::getContent("reject_message");?>');
		}
	});
</script>