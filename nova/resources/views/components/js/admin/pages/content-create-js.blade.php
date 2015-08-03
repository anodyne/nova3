<script>
	$('[name="key"]').change(function(e)
	{
		var field = $(this);
		var value = $(this).val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.content.checkKey') }}",
			data: { key: $(this).val() },
			success: function(data)
			{
				if (data.code == 0)
				{
					field.val("");

					swal({
						title: "Error!",
						text: "Page content keys must be unique. Another page content item is already using the key you gave. Please enter a unique key.",
						type: "error",
						timer: null,
						html: true
					});
				}
			}
		});
	});
</script>