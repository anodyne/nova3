<link href="{{ NOVAURL }}assets/css/jquery.Jcrop.min.css" rel="stylesheet">
<script src="{{ NOVAURL }}assets/js/jquery.Jcrop.min.js"></script>
<script>

	$(document).ready(function()
	{
		var jcrop_api;

		$('#jcrop').Jcrop({
			onSelect: showCoords,
			onRelease: clearCoords,
			aspectRatio: 1/1
		},function(){
			jcrop_api = this;
		});

		function showCoords(c)
		{
			$('[name="x1"]').val(c.x);
			$('[name="y1"]').val(c.y);
			$('[name="x2"]').val(c.x2);
			$('[name="y2"]').val(c.y2);
			$('[name="width"]').val(c.w);
			$('[name="height"]').val(c.h);
		};

		function clearCoords()
		{
			$('#coordinates input').val('');
		};
	});

	$('#coordinates').on('change', 'input', function(e)
	{
		var x1 = $('[name="x1"]').val(),
			x2 = $('[name="x2"]').val(),
			y1 = $('[name="y1"]').val(),
			y2 = $('[name="y2"]').val();
		
		jcrop_api.setSelect([x1, y1, x2, y2]);
	});

</script>