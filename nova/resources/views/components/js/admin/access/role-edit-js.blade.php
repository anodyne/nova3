<script>
	$('[name="display_name"]').change(function(e)
	{
		var value = $(this).val();

		// Update the key field only if there isn't something there
		if ($('[name="name"]').val() == "")
			$('[name="name"]').val(value.replace(/\W+/g, '-').toLowerCase()).trigger('change');
	});

	$('[name="name"]').change(function(e)
	{
		var field = $(this);
		var value = $(this).val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.access.roles.checkKey') }}",
			data: { key: $(this).val() },
			success: function(data)
			{
				if (data.code == 0)
				{
					field.val("");

					swal({
						title: "Error!",
						text: "Role keys must be unique. Another role is already using the key you gave. Please enter a unique key.",
						type: "error",
						timer: null,
						html: true
					});
				}
			}
		});
	});
</script>