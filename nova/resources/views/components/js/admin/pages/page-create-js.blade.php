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
		$('#pageControls').removeClass('hide');
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

	$('[name$="[uri]"]').on('change', function(e)
	{
		var field = $(this);
		var value = $(this).val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{ route('admin.pages.checkUri') }}",
			data: {
				uri: $(this).val()
			},
			success: function(data)
			{
				if (data.code == 0)
				{
					field.val("");
					alert("You've entered a URI that's already being used by another page. Please enter a different URI for this page.");
				}
				else
				{
					var type = $('[name="type"]:checked').val();
					var uri = field.val();
					var key;

					// Change all slashes into periods
					key = uri.replace(/\//g, ".");

					// Take out all the URI variables
					key = key.replace(/{(.*?)}/g, "");

					// If we have consecutive periods, make them 1
					key = key.replace(/\.{2,}/g, ".");

					// Take periods off the beginning of the string
					if (key.charAt(0) == ".")
						key = key.substr(1);

					// Take periods off the end of the string
					if (key.slice(-1) == ".")
						key = key.substring(0, key.length - 1);

					if (type == "basic")
						$('[name="basic[key]"]').val(key).trigger('change');

					if (type == "advanced")
						$('[name="advanced[key]"]').val(key).trigger('change');
				}
			}
		});
	});

	$(function()
	{
		if ($('[name="type"]:checked').val() != '')
		{
			if ($('[name="type"]:checked').val() == 'basic')
			{
				$('#pageBasic').removeClass('hide');
				$('#pageContent').removeClass('hide');
				$('#pageControls').removeClass('hide');
			}

			if ($('[name="type"]:checked').val() == 'advanced')
			{
				$('#pageAdvanced').removeClass('hide');
				$('#pageContent').removeClass('hide');
				$('#pageControls').removeClass('hide');
			}

		}
	});
</script>