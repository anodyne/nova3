<script type="text/javascript">
	
	$(document).on('change', '.js-email-driver', function(){
		var checked = $('.js-email-driver:checked').val();

		if (checked == "smtp")
		{
			$('#sendmailOptions').hide();
			$('#smtpOptions').show();
		}
		if (checked == "sendmail")
		{
			$('#smtpOptions').hide();
			$('#sendmailOptions').show();
		}
		else
		{
			$('#smtpOptions').hide();
			$('#sendmailOptions').hide();
		}
	});

</script>