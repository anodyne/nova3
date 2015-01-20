<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title') &bull; Nova 3</title>
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">

		@if (app('env') == 'production')
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		@else
			<link href="//localhost/global/bootstrap/3.3/css/bootstrap.min.css" rel="stylesheet">
		@endif

		<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,500,700" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Cuprum:400,700" rel="stylesheet">

		{!! HTML::style('nova/src/Setup/views/design/css/style.setup.css') !!}
		{!! HTML::style('nova/src/Setup/views/design/css/fonts.setup.css') !!}
		{!! HTML::style('nova/src/Setup/views/design/css/retina.setup.css', ['media' => 'only screen and (-moz-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)']) !!}
	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-md-1">
						<div class="product-logo">Logo</div>
					</div>
					<div class="col-md-10">
						<span class="product">Nova 3 Setup</span>
						<span class="divider">/</span>
						<span class="process">@yield('header')</span>
					</div>
					<div class="col-md-1">
						<div class="menu">Menu</div>
					</div>
				</div>
			</div>
			<!--<div class="container">
				<div class="pull-right" id="steps">
					@yield('steps')
				</div>
				<h1>
					Nova 3 Setup
					&nbsp;&rsaquo;&nbsp;
					@yield('header')
				</h1>
			</div>-->
		</header>

		<div class="container">
			<div class="row">
				<div class="col-md-3 col-md-offset-1">
					<nav>
						Sidebar
					</nav>
				</div>
				<div class="col-md-7">
					<main>
						<div class="row">
							<div class="col-xs-12">
								@if (Session::has('flash.message'))
									@include('partials.flash')
								@endif

								@yield('content')
							</div>
						</div>
					</main>
				</div>
			</div>
		</div>

		<!--<section>
			<div class="container">
				@if (Session::has('flash.message'))
					@include('partials.flash')
				@endif

				@yield('content')
				
				<div class="lower">@yield('controls')</div>
			</div>
		</section>-->

		<footer>
			<div class="container">
				&copy; {{ Date::now()->year }} Anodyne Productions
			</div>
		</footer>

		@if (app('env') == 'production')
			<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		@else
			<script src="//localhost/global/jquery/jquery-2.1.1.min.js"></script>
			<script src="//localhost/global/bootstrap/3.3/js/bootstrap.min.js"></script>
		@endif
		@yield('scripts')
	</body>
</html>