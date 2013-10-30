<link href="{{ NOVAURL }}assets/css/dropzone/basic.css" rel="stylesheet">
<link href="{{ NOVAURL }}assets/css/dropzone/dropzone.css" rel="stylesheet">
<script type="text/javascript" src="{{ NOVAURL }}assets/js/dropzone.min.js"></script>
<script type="text/javascript">

	$(document).ready(function()
	{
		var upload = new Dropzone(".dropzone-upload", {
			url: "{{ URL::to('admin/catalog/skins_upload/'.$id) }}",
			maxFilesize: "{{ $uploadSize }}",
			acceptedFiles: "{{ $acceptedFiles }}",
			previewTemplate: '<div class="dz-preview dz-file-preview hidden"><div class="dz-details text-center"><div class="dz-filename hidden"><span data-dz-name></span></div><div class="dz-size hidden" data-dz-size></div><img data-dz-thumbnail /></div><div class="dz-progress hidden"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark hidden"><span>✔</span></div><div class="dz-error-mark hidden"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>'
		});

		// Drag over event
		upload.on('dragover', function(e)
		{
			$('.dropzone-upload').addClass('dropzone-upload-hover');
		});

		// Drag leave event
		upload.on('dragleave', function(e)
		{
			$('.dropzone-upload').removeClass('dropzone-upload-hover');
		});

		// Drop event
		upload.on('drop', function(e)
		{
			$('.dropzone-upload').removeClass('dropzone-upload-hover');

			// Add the key as a header to use later
			upload.options.headers = {
				"Upload-Key": e.target.id
			};
		});

		// Added file event
		upload.on('success', function(file)
		{
			var container = this.element.id;

			$('#' + container + ' .text-success').removeClass('hidden');
		});

		// Error event
		upload.on('error', function(file, error, xhr)
		{
			var container = this.element.id;

			$('#' + container + ' .text-danger').removeClass('hidden');
			$('#' + container).append('<p class="help-block text-danger text-center">' + error + '</p>');
		});
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