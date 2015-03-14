<script>
	$('[name="type"]').on('change', function(e)
	{
		var selected = $('[name="type"]:checked').val();

		if (selected == "basic")
		{
			$('#pageAdvanced').addClass('hide');
			$('#pageBasic').removeClass('hide');
		}

		if (selected == "advanced")
		{
			$('#pageBasic').addClass('hide');
			$('#pageAdvanced').removeClass('hide');
		}

		$('#pageContent').removeClass('hide');
	});

	$('[name$="[key]"]').on('change', function(e)
	{
		var field = $(this);
		var value = $(this).val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.pages.checkKey') }}",
			data: {
				key: $(this).val(),
				"_token": "{{ csrf_token() }}"
			},
			success: function(data)
			{
				if (data.code == 0)
				{
					field.val("");
					alert("Page keys must be unique and another page already exists with that key. Please enter a unique key.");
				}
			}
		});
	});
</script>