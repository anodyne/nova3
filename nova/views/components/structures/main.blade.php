<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $_page->description }}">
		<meta name="viewport" content="width=device-width">

		<title>{{ $_page->present()->title }} &bull; {{ $siteName }}</title>
		
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		{!! HTML::style('nova/views/design/css/base.style.css') !!}
	</head>
	<body>
		{!! $template or '' !!}

		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		{!! $javascript or '' !!}
	</body>
</html>