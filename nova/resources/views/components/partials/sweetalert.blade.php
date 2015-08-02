@if (session()->has('flash_message'))
	<script>
		swal({
			title: "{{ session('flash_message.title') }}",
			text: "{{ session('flash_message.message') }}",
			type: "{{ session('flash_message.level') }}",
			timer: 2500,
			showConfirmButton: false,
			html: true
		});
	</script>
@endif

@if (session()->has('flash_message_overlay'))
	<script>
		swal({
			title: "{{ session('flash_message_overlay.title') }}",
			text: "{{ session('flash_message_overlay.message') }}",
			type: "{{ session('flash_message_overlay.level') }}",
			timer: null,
			confirmButtonText: "OK",
			html: true,
			allowOutsideClick: true
		});
	</script>
@endif