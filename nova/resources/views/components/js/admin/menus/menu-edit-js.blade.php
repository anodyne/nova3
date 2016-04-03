<script>
	$('[name="name"]').change(function (e) {
		if ($('[name="key"]').val() == "") {
			$.ajax({
				type: "POST",
				dataType: "text",
				url: "{{ route('admin.menus.generateKey') }}",
				data: { name: $(this).val() },
				success: function (data) {
					$('[name="key"]').val(data).trigger('change');
				}
			})
		}
	})

	$('[name="key"]').change(function (e) {
		var field = $(this)
		var value = $(this).val()

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.menus.checkKey') }}",
			data: { key: $(this).val() },
			success: function (data) {
				if (data.code == 0) {
					field.val("")

					swal({
						title: "Error!",
						text: "Menu keys must be unique. Another menu is already using the key you gave. Please enter a unique key.",
						type: 'error',
						html: true,
						timer: null
					})
				}
			}
		})
	})
</script>