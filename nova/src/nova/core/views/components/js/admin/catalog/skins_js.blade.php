<link href="{{ NOVAURL }}assets/css/dropzone/basic.css" rel="stylesheet">
<link href="{{ NOVAURL }}assets/css/dropzone/dropzone.css" rel="stylesheet">
<script type="text/javascript" src="{{ NOVAURL }}assets/js/dropzone.min.js"></script>
<script type="text/javascript">

	$(document).ready(function()
	{
		$("#dropzone").dropzone({ url: "/file/post" });
	});

	$(document).on('click', '.js-skin-action', function(e)
	{
		var id = $(this).data('id');
		var action = $(this).data('action');
		var location = $(this).data('location');

		if (action == 'delete')
		{
			$('#deleteSkin').modal({
				remote: "{{ URL::to('ajax/delete/skin') }}/" + id
			}).modal('show');
		}

		if (action == 'install')
		{
			$('#installSkin').modal({
				remote: "{{ URL::to('ajax/add/skin') }}/" + location
			}).modal('show');
		}

		e.preventDefault();
	});

</script>