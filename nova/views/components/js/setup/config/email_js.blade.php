<script type="text/javascript">
	
	$(document).on('change', '[name="driver"]', function()
	{
		var checked = $('[name="driver"]:checked').val();

		if (checked == "smtp")
		{
			$('#sendmailOptions').addClass('hidden');
			$('#smtpOptions').removeClass('hidden');
		}
		else if (checked == "sendmail")
		{
			$('#smtpOptions').addClass('hidden');
			$('#sendmailOptions').removeClass('hidden');
		}
		else
		{
			$('#smtpOptions').addClass('hidden');
			$('#sendmailOptions').addClass('hidden');

		}
	});

</script>