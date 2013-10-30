<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova 3 &bull; {{ $title }}</title>
		
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Anodyne Productions">
		
		@if (isset($_redirect))
			{{ $_redirect }}
		@endif

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ NOVAURL }}assets/css/fonts.css">
		<link rel="stylesheet" href="{{ NOVAURL }}assets/css/fonts.setup.css">
		<link rel="stylesheet" href="{{ NOVAURL }}views/design/style.setup.css">

		<!-- High pixel density displays -->
		<link rel='stylesheet' href='{{ NOVAURL }}views/design/retina.setup.css' media='only screen and (-moz-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)'>
	</head>
	<body>
		{{ $template }}

		<?php include_once NOVAPATH.'views/components/js/core/jquery_js.php';?>

		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
		<script>
			
			$(document).ready(function()
			{
				$('.tip-above').tooltip();
				$('.tip-below').tooltip({ placement: 'bottom' });
			});

		</script>
		{{ $javascript }}
	</body>
</html>