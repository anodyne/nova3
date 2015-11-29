<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
	// Destroy all modals when they're hidden
	$('.modal').on('hidden.bs.modal', function()
	{
		$('.modal').removeData('bs.modal')
	})

	$(function()
	{
		$('.js-tooltip-top').tooltip({ placement: 'top' })
		$('.js-tooltip-bottom').tooltip({ placement: 'bottom' })
		$('.js-tooltip-left').tooltip({ placement: 'left' })
		$('.js-tooltip-right').tooltip({ placement: 'right' })
	})
</script>