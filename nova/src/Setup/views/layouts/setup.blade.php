<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title') &bull; Nova NextGen</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		@if (App::environment() == 'production')
			<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
		@else
			<link href="//localhost/global/bootstrap/3.3/css/bootstrap.min.css" rel="stylesheet">
		@endif

		<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,500,700" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Cuprum:400" rel="stylesheet">

		<link rel="stylesheet" href="/nova/laravel5/nova/src/Setup/views/design/css/style.setup.css">
		<link rel="stylesheet" href="/nova/laravel5/nova/src/Setup/views/design/css/fonts.setup.css">
		<link rel="stylesheet" href="/nova/laravel5/nova/src/Setup/views/design/css/retina.setup.css" media='only screen and (-moz-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)'>
	</head>
	<body>
		<header>
			<div class="container">
				<!--<div class="logo"></div>-->
				<div class="pull-right" id="steps">@yield('steps')</div>
				<h1>Nova 3 Setup &nbsp;&rsaquo;&nbsp; @yield('header')</h1>
			</div>
		</header>

		<section>
			<div class="container">
				<div class="head">
					
					<div style="clear:both;"></div>
				</div>
				
				<div class="content">
					<div id="loaded">
						@if (Session::has('flash.message'))
							@include('partials.flash')
						@endif

						@yield('content')
					</div>

					<div id="loading" class="hidden">
						<h2><img src="{{ asset('nova/views/design/images/loading.gif') }}" alt=""><small>Loading...</small></h2>
					</div>
				</div>
				
				<div class="lower">@yield('controls')</div>
			</div>
		</section>

		<footer>
			&copy; {{ Date::now()->year }} Anodyne Productions
		</footer>

		@if (App::environment() == 'production')
			<!--[if lt IE 9]>
				<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
			<![endif]-->
			<!--[if gte IE 9]><!-->
				<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
			<!--<![endif]-->

			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		@else
			<!--[if lt IE 9]>
				<script src="//localhost/global/jquery/jquery-1.11.1.min.js"></script>
			<![endif]-->
			<!--[if gte IE 9]><!-->
				<script src="//localhost/global/jquery/jquery-2.1.1.min.js"></script>
			<!--<![endif]-->

			<script src="//localhost/global/bootstrap/3.3/js/bootstrap.min.js"></script>
		@endif
		@yield('scripts')
	</body>
</html>