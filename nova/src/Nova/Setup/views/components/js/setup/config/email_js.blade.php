<script type="text/javascript">
	
	$(document).on('change', '.js-email-driver', function(){
		var checked = $('.js-email-driver:checked').val();

		if (checked == "smtp")
			$('#smtpOptions').show();
		else
			$('#smtpOptions').hide();
	});

</script>