{!! HTML::script('nova/resources/js/typeahead.bundle.min.js') !!}
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

	var substringMatcher = function(strs) {
		return function findMatches(q, cb) {
			var matches, substringRegex;

			// an array that will be populated with substring matches
			matches = [];

			// regex used to determine if a string contains the substring `q`
			substrRegex = new RegExp(q, 'i');

			// iterate through the pool of strings and for any string that
			// contains the substring `q`, add it to the `matches` array
			$.each(strs, function(i, str) {
				if (substrRegex.test(str)) {
					matches.push(str);
				}
			});

			cb(matches);
		};
	};

	var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
		'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
		'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
		'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
		'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
		'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
		'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
		'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
		'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
	];

	$('[name="permissions_query"]').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	},
	{
		name: 'states',
		source: substringMatcher(states)
	});
</script>