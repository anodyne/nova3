<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova 3 Environment Tests</title>

		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
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
			h1, h2, h3 {
				font-family: "Open Sans";
				font-weight: 300;
			}
			h2, h3, th, strong {
				font-weight: 600;
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
						<th class="col-lg-2">Component</th>
						<th>Description</th>
						<th class="col-lg-1 text-center">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (version_compare(PHP_VERSION, '5.4.0', '>=')): ?>
						<tr>
					<?php else: ?>
						<tr class="danger">
					<?php endif;?>
						<td><p class="lead">PHP 5.4+</p></td>
						<td>
							<p>Nova 3 requires at least PHP 5.4.0 in order to run.</p>

							<?php if (version_compare(PHP_VERSION, '5.4.0', '<')): ?>
								<p><strong>Your server is currently running PHP <?php echo PHP_VERSION;?>. Please contact your host about options for upgrading your account to run PHP 5.4.0 or higher.</strong></p>
							<?php endif;?>
						</td>
						<td class="text-center">
							<?php if (version_compare(PHP_VERSION, '5.4.0', '>=')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-remove text-danger"></i>
							<?php endif;?>
						</td>
					</tr>

					<?php if (defined('PDO::ATTR_DRIVER_NAME')): ?>
						<tr>
					<?php else: ?>
						<tr class="danger">
					<?php endif;?>
						<td><p class="lead">PDO</p></td>
						<td>
							<p>Nova 3 requires a PDO driver to be installed. Most installations of PHP 5.4 come with this installed.</p>

							<?php if ( ! defined('PDO::ATTR_DRIVER_NAME')): ?>
								<p><strong>Without a PDO driver, Nova 3 will be unable to connect to your database. Please contact your host about getting a PDO driver (to match whatever type of database you have) installed for your account.</strong></p>
							<?php endif;?>
						</td>
						<td class="text-center">
							<?php if (defined('PDO::ATTR_DRIVER_NAME')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-remove text-danger"></i>
							<?php endif;?>
						</td>
					</tr>
					
					<?php if (function_exists('mcrypt_module_open')): ?>
						<tr>
					<?php else: ?>
						<tr class="danger">
					<?php endif;?>
						<td><p class="lead">MCrypt</p></td>
						<td>
							<p>For security purposes, passwords are hashed using PHP's MCrypt extension. Without this, you won't be able to properly hash passwords.</p>

							<?php if ( ! function_exists('mcrypt_module_open')): ?>
								<p><strong>Please contact your host about getting the MCrypt extension activated for your account.</strong></p>
							<?php endif;?>
						</td>
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
						<th class="col-lg-2">Component</th>
						<th>Description</th>
						<th class="col-lg-1 text-center">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (extension_loaded('apc') and ini_get('apc.enabled')): ?>
						<tr>
					<?php else: ?>
						<tr class="warning">
					<?php endif;?>
						<td><p class="lead">APC</p></td>
						<td><p>In order to speed up the execution of many of Nova's pages, views and content from the database are cached. While the cache will work without APC, you can speed up Nova by enabling APC caching if your server supports it.</p></td>
						<td class="text-center">
							<?php if (extension_loaded('apc') and ini_get('apc.enabled')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-exclamation-sign text-warning"></i>
							<?php endif;?>
						</td>
					</tr>

					<?php if (extension_loaded('fileinfo')): ?>
						<tr>
					<?php else: ?>
						<tr class="warning">
					<?php endif;?>
						<td><p class="lead">FileInfo</p></td>
						<td><p>In order to upload images to the server, Nova uses PHP's FileInfo extension to make sure the file type matches acceptable image formats. While this isn't a requirement for using Nova, it certainly is a nice to have. If the FileInfo extension isn't enabled on your server, you can contact your host about getting it enabled.</p></td>
						<td class="text-center">
							<?php if (extension_loaded('fileinfo')): ?>
								<i class="glyphicon glyphicon-ok text-success"></i>
							<?php else: ?>
								<i class="glyphicon glyphicon-exclamation-sign text-warning"></i>
							<?php endif;?>
						</td>
					</tr>

					<?php if (function_exists('gd_info')): ?>
						<tr>
					<?php else: ?>
						<tr class="warning">
					<?php endif;?>
						<td><p class="lead">GD</p></td>
						<td><p>In order to crop uploaded user/characters images to create avatars, Nova uses the GD library found in PHP. While this isn't a requirement for using Nova, it certainly is a nice to have. If GD isn't enabled on your server, you can contact your host about getting it enabled.</p></td>
						<td class="text-center">
							<?php if (function_exists('gd_info')): ?>
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