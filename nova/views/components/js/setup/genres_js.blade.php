<script type="text/javascript">

	$(document).on('click', '.js-do-install', function(e)
	{
		e.preventDefault();

		var $this = $(this);

		$.ajax({
			beforeSend: function()
			{
				// Hide the install button
				$this.addClass('hide');
				
				// Show the loader
				$this.parent().next('p').removeClass('hide');
			},
			type: "POST",
			url: "{{ URL::to('setup/ajax/install_genre') }}",
			data: { genre: $this.data('genre'), '_token': "{{ csrf_token() }}" },
			dataType: 'json',
			success: function(data)
			{
				// Hide the loader
				$this.parent().next('p').addClass('hide');
				
				if (data.code == 1)
				{
					// Update which label is shown
					$this.parent().next('p').next('p').children('.label').addClass('hide');
					$this.parent().next('p').next('p').children('.label-success').removeClass('hide');

					// Hide the button
					$this.hide();
					
					// Show the uninstall button
					$this.next('button').removeClass('hide');
				}
				else
					$this.removeClass('hide');
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
				$this.addClass('hide');
				
				// Show the loader
				$this.parent().next('p').removeClass('hide');
			},
			type: "POST",
			url: "{{ URL::to('setup/ajax/uninstall_genre') }}",
			data: { genre: $this.data('genre'), '_token': "{{ csrf_token() }}" },
			dataType: 'json',
			success: function(data)
			{
				// Hide the loader
				$this.parent().next('p').addClass('hide');
				
				if (data.code == 1)
				{
					// Update which label is shown
					$this.parent().next('p').next('p').children('.label-success').addClass('hide');
					$this.parent().next('p').next('p').children(':last-child').removeClass('hide');

					// Hide the button
					$this.hide();
					
					// Show the install button
					$this.prev('button').removeClass('hide');
				}
				else
					$this.removeClass('hide');
			}
		});
	});
	
</script>