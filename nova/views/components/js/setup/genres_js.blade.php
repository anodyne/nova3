<script type="text/javascript">

	$(document).on('click', '.js-do-install', function(e)
	{
		e.preventDefault();

		var $this = $(this);

		$.ajax({
			beforeSend: function()
			{
				// Hide the install button
				$this.addClass('hidden');
				
				// Show the loader
				$this.parent().next('p').removeClass('hidden');
			},
			type: "POST",
			url: "{{ URL::to('setup/ajax/install_genre') }}",
			data: { genre: $this.data('genre'), '_token': "{{ csrf_token() }}" },
			dataType: 'json',
			success: function(data)
			{
				// Hide the loader
				$this.parent().next('p').addClass('hidden');
				
				if (data.code == 1)
				{
					// Update which label is shown
					$this.parent().next('p').next('p').children('.label').addClass('hidden');
					$this.parent().next('p').next('p').children('.label-success').removeClass('hidden');

					// Hide the button
					$this.hide();
					
					// Show the uninstall button
					$this.next('button').removeClass('hidden');
				}
				else
					$this.removeClass('hidden');
			}
		});
	});
	
	$(document).on('click', '.js-do-uninstall', function(e)
	{
		e.preventDefault();

		var $this = $(this);

		$.ajax({
			beforeSend: function()
			{
				// Hide the install button
				$this.addClass('hidden');
				
				// Show the loader
				$this.parent().next('p').removeClass('hidden');
			},
			type: "POST",
			url: "{{ URL::to('setup/ajax/uninstall_genre') }}",
			data: { genre: $this.data('genre'), '_token': "{{ csrf_token() }}" },
			dataType: 'json',
			success: function(data)
			{
				// Hide the loader
				$this.parent().next('p').addClass('hidden');
				
				if (data.code == 1)
				{
					// Update which label is shown
					$this.parent().next('p').next('p').children('.label-success').addClass('hidden');
					$this.parent().next('p').next('p').children(':last-child').removeClass('hidden');

					// Hide the button
					$this.hide();
					
					// Show the install button
					$this.prev('button').removeClass('hidden');
				}
				else
					$this.removeClass('hidden');
			}
		});
	});
	
</script>