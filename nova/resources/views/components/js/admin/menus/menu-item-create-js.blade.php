<script>
	$('[name="type"]').change(function (e) {
		var selected = $('[name="type"] option:selected').val()

		$('#external-link').addClass('hide')
		$('#page-link').addClass('hide')

		$('[name="link"]').val('')
		$('[name="page_id"]').val('')

		if (selected == "page") {
			$('#page-link').removeClass('hide')
		} else {
			$('#external-link').removeClass('hide')
		}
	})

	$(function () {
		var typeSelected = $('[name="type"] option:selected').val()

		if (typeSelected != "") {
			if (typeSelected == "page") {
				$('#page-link').removeClass('hide')
			} else {
				$('#external-link').removeClass('hide')
			}
		}
	})
</script>