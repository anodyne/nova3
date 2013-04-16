<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ $title }}</title>
		
		<meta name="description" content="{{ $settings->meta_description }}">
		<meta name="keywords" content="{{ $settings->meta_keywords }}">
		<meta name="author" content="{{ $settings->meta_author }}">
		
		<!-- Bootstrap styles -->
		{{ Html::style('nova/src/Nova/Assets/css/bootstrap.min.css') }}

		<!-- Web fonts styles -->
		{{ Html::style('nova/src/Nova/Assets/css/fonts.css') }}
		
		<!-- Nova's base styles and any user-defined styles -->
		@if (is_file(APPPATH.'views/'.$skin.'/design/style.login.css'))
			{{ Html::style('app/views/'.$skin.'/design/style.login.css') }}
		@else
			{{ Html::style('nova/src/Nova/Core/views/design/style.css') }}
			{{ Html::style('nova/src/Nova/Core/views/design/style.login.css') }}
			
			@if (is_file(APPPATH.'views/'.$skin.'/design/custom.login.css'))
				{{ Html::style('app/views/'.$skin.'/design/custom.login.css') }}
			@endif
		@endif
	</head>
	<body>
		{{ $layout }}

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Nova's core Javascript -->
		<?php include SRCPATH.'Core/views/components/js/core/login_js.php';?>

		<!-- Nova's per-page Javascript -->
		{{ $javascript }}
	</body>
</html>