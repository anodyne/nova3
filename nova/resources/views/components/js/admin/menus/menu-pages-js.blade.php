<script>
	$('.js-checkAll').change(function (e) {
		var checked = $('.js-checkAll').is(":checked")

		if (checked) {
			$('.data-table input[type=checkbox]').each(function () {
				$(this).prop('checked', true).trigger('change')
			})

			$(this).next('span').text("Unselect All")
		} else {
			$('.data-table input[type=checkbox]').each(function () {
				$(this).prop('checked', false).trigger('change')
			})
			
			$(this).next('span').text("Select All")
		}
	})

	$('.data-table input[type=checkbox]').change(function (e) {
		if ($('.data-table input[type=checkbox]:checked').length > 0) {
			$('#controls').removeClass('hide')
		} else {
			$('#controls').addClass('hide')
		}
	})
</script>