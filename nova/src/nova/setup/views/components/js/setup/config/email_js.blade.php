<script type="text/javascript">
	
	$(document).on('change', '[name="driver"]', function(){
		var checked = $('[name="driver"]:checked').val();

		if (checked == "smtp")
		{
			$('#sendmailOptions').addClass('hide');
			$('#smtpOptions').removeClass('hide');
		}
		else if (checked == "sendmail")
		{
			$('#smtpOptions').addClass('hide');
			$('#sendmailOptions').removeClass('hide');
		}
		else
		{
			$('#smtpOptions').addClass('hide');
			$('#sendmailOptions').addClass('hide');

		}
	});

</script>