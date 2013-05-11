<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova 3 Environment Tests</title>

		<link rel="stylesheet" href="nova/src/Nova/Assets/css/bootstrap.min.css">
		<style>
			@import "http://fonts.googleapis.com/css?family=Open+Sans:300,400,600";

			body {
				font-family: "Open Sans";
				font-size: 16px;
				line-height: 1.75;
			}
			.glyphicon {
				font-size: 32px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>Nova 3 Environment Tests</h1>
			</div>

			<h3>Required</h3>

			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col col-lg-2">Component</th>
						<th>Description</th>
						<th class="col col-lg-1 text-center">Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><p class="lead">PHP 5.4+</p></td>
						<td>Your host must be running at least version 5.4.0 in order for Nova 3 to run. If this test fails, you won't be able to install Nova 3 and will need to contact your host to see about correcting this issue.</td>
						<td class="text-center">
							<?php if (version_compare(PHP_VERSION, '5.4.0', '>=')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-remove text-danger"></i>
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<td><p class="lead">PDO</p></td>
						<td>In order to connect to the database where Nova's data is stored, you must have the PDO driver installed. Most installations of PHP 5.4 come with this installed. If this test fails, you won't be able to install Nova 3 and will need to contact your host to see about correcting this issue.</td>
						<td class="text-center">
							<?php if (defined('PDO::ATTR_DRIVER_NAME')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-remove text-danger"></i>
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<td><p class="lead">MCrypt</p></td>
						<td>For security purposes, passwords are hashed using PHP's MCrypt extension. Without this, you won't be able to properly hash passwords. If this test fails, you will need to contact your host to see about correcting the issue.</td>
						<td class="text-center">
							<?php if (function_exists('mcrypt_module_open')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-remove text-danger"></i>
							<?php endif;?>
						</td>
					</tr>
				</tbody>
			</table>

			<h3>Optional</h3>
			
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col col-lg-2">Component</th>
						<th>Description</th>
						<th class="col col-lg-1 text-center">Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><p class="lead">APC</p></td>
						<td>In order to speed up the execution of some of Nova's pages, things are cached. While the cache will work without APC, you can speed up Nova by enabling APC caching if your server supports it.</td>
						<td class="text-center">
							<?php if (extension_loaded('apc') and ini_get('apc.enabled')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-exclamation-sign text-warning"></i>
							<?php endif;?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>