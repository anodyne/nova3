<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>404</title>

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
			}
			h1 small {
				display: block;
				margin-top: 20px;
				color: #888;
				font-weight: 400;
				font-size: 18px;
			}
			.btn {
				margin-top: 50px;
				border-radius: 3px;
				font-weight: 600;
				color: #666;
			}
			.btn:hover {
				color: #444;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<h1><?php echo $header;?><small><?php echo nl2br($message);?></small></h1>

			<a href="javascript: history.go(-1)" class="btn btn-large btn-block">Go Back</a>
		</div>
	</body>
</html>