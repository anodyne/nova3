<script>
	$('[name="name"]').change(function(e)
	{
		var field = $(this);
		var value = $(this).val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.access.permissions.checkKey') }}",
			data: { key: $(this).val() },
			success: function(data)
			{
				if (data.code == 0)
				{
					field.val("");

					swal({
						title: "Error!",
						text: "Permission keys must be unique. Another permission is already using the key you gave. Please enter a unique key.",
						type: "error",
						timer: null,
						html: true
					});
				}
			}
		});
	});
</script>