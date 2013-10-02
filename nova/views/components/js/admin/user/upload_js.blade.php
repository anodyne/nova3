<link href="{{ NOVAURL }}assets/css/dropzone/basic.css" rel="stylesheet">
<link href="{{ NOVAURL }}assets/css/dropzone/dropzone.css" rel="stylesheet">
<script src="{{ NOVAURL }}assets/js/dropzone.min.js"></script>
<script>

	$(document).ready(function()
	{
		var upload = new Dropzone(".dropzone-upload", {
			url: "{{ URL::to('admin/user/upload/'.$id) }}",
			maxFilesize: "{{ $uploadSize }}",
			acceptedFiles: "{{ $acceptedFiles }}",
			previewTemplate: '<div class="dz-preview dz-file-preview hide"><div class="dz-details text-center"><div class="dz-filename hide"><span data-dz-name></span></div><div class="dz-size hide" data-dz-size></div><img data-dz-thumbnail /></div><div class="dz-progress hide"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark hide"><span>✔</span></div><div class="dz-error-mark hide"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>'
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
		});

		// Added file event
		upload.on('success', function(file)
		{
			var container = this.element.id;

			$('#' + container + ' .text-success').removeClass('hide');
		});

		// Error event
		upload.on('error', function(file, error, xhr)
		{
			var container = this.element.id;

			$('#' + container + ' .text-danger').removeClass('hide');
			$('#' + container).append('<p class="help-block text-danger text-center">' + error + '</p>');
		});
	});

</script>