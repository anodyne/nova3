<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo $settings->meta_description;?>">
		<meta name="keywords" content="<?php echo $settings->meta_keywords;?>">
		<meta name="author" content="<?php echo $settings->meta_author;?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>

		<!-- Bootstrap styles -->
		<link rel="stylesheet" href="<?php echo SRCURL;?>Assets/css/bootstrap.min.css">

		<!-- IcoMoon icon font -->
		<link rel="stylesheet" href="<?php echo SRCURL;?>Assets/css/icomoon.css">
		
		<!-- Nova's base styles and any user-defined styles -->
		<?php if (is_file(APPPATH.'views/'.$skin.'/design/style.css')): ?>
			<link rel="stylesheet" href="<?php echo APPURL;?>views/<?php echo $skin;?>/design/style.css">
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo SRCURL;?>Core/views/design/style.css">
			
			<?php if (is_file(APPPATH.'views/'.$skin.'/design/custom.css')): ?>
				<link rel="stylesheet" href="<?php echo APPURL;?>views/<?php echo $skin;?>/design/custom.css">
			<?php endif;?>
		<?php endif;?>

		<!-- Bootstrap responsive design -->
		<link rel="stylesheet" href="<?php echo SRCURL;?>Assets/css/bootstrap-responsive.min.css">
	</head>
	<body>
		<?php echo $layout;?>

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Nova's core Javascript -->
		<?php include_once SRCPATH.'Core/views/components/js/core/main_js.php';?>

		<!-- Nova's per-page Javascript -->
		<?php echo $javascript;?>
	</body>
</html>