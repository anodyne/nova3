<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Error!</title>

		<link rel="stylesheet" href="{{ NOVAURL }}assets/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
		<style>
			body {
				background: #f2f2f2;
				font-family: "Open Sans", helvetica, arial, sans-serif;
				font-size: 16px;
				line-height: 1.75;
			}
			.container {
				width: 600px;
			}
			h1 {
				color: #c00;
				font-weight: 300;
				font-size: 52px;
				text-align: center;
				font-family: "Open Sans", helvetica, arial, sans-serif;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<h1>Error!</h1>
			
			<p>{{ $message }}</p>
		</div>
	</body>
</html>