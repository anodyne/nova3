<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">

		<title>{{ $pageTitle }} &bull; {{ $siteName }}</title>
		
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 400;
				font-family: 'Open Sans';
			}

			.container {
				text-align: center;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
				font-family: "Open Sans Condensed";
				font-weight: 300;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		{!! $template or '' !!}

		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		{!! $javascript or '' !!}
	</body>
</html>