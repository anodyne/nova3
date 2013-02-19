<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{{ $title }}</title>
		
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Anodyne Productions">
		
		@if (isset($_redirect))
			{{ $_redirect }}
		@endif
		
		<link rel="stylesheet" href="{{ SRCURL }}Assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ SRCURL }}Assets/css/icomoon.css">
		<link rel="stylesheet" href="{{ SRCURL }}Setup/views/design/style.css">
	</head>
	<body>
		{{{ $layout }}}

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		{{{ $javascript }}}
		
		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</body>
</html>