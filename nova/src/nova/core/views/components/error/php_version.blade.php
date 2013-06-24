<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Insufficient PHP Version</title>

		<link rel="stylesheet" href="<?php echo SRCURL;?>assets/css/bootstrap.min.css">
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
			<h1>PHP 5.4 Required</h1>

			<p>Nova 3 makes use of several advanced PHP features only found in version 5.4.0 or higher. In order to continue, you will need to be running PHP 5.4.</p>

			@if ($env == 'local')
				<p>We've detected this is a testing environment. If you're running on a local server, please update your version of PHP to 5.4.0 or higher and then try again. If this is running on a physical server, either update to PHP 5.4 or contact your host about the possibility of using PHP 5.4.</p>
			@else
				<p>We've detected this is a production environment. Please contact your host about options for running PHP 5.4 on this server.</p>
			@endif
		</div>
	</body>
</html>