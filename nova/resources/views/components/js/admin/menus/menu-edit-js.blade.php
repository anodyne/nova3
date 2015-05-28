<script>
	$('[name="name"]').on('change', function(e)
	{
		if ($('[name="key"]').val() == "")
		{
			$.ajax({
				type: "POST",
				dataType: "text",
				url: "{{ route('admin.menus.generateKey') }}",
				data: { name: $(this).val() },
				success: function(data)
				{
					$('[name="key"]').val(data).trigger('change');
				}
			});
		}
	});

	$('[name="key"]').on('change', function(e)
	{
		var field = $(this);
		var value = $(this).val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.menus.checkKey') }}",
			data: { key: $(this).val() },
			success: function(data)
			{
				if (data.code == 0)
				{
					field.val("");
					alert("Menu keys must be unique and another menu already exists with that key. Please enter a unique key.");
				}
			}
		});
	});
</script>