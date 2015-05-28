<script>
	$('[name="key"]').on('change', function(e)
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
					alert("Page content keys must be unique and another page content item already exists with that key. Please enter a unique key.");
				}
			}
		});
	});
</script>