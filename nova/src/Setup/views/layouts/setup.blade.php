<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title') &bull; Nova 3</title>
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">

		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

		{!! HTML::style('nova/src/Setup/views/design/css/style.setup.css') !!}
		{!! HTML::style('nova/src/Setup/views/design/css/fonts.setup.css') !!}
		{!! HTML::style('nova/src/Setup/views/design/css/retina.setup.css', ['media' => 'only screen and (-moz-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)']) !!}
	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-sm-10">
						<span class="product">{{ config('nova.app.name') }} Setup</span>
						<span class="divider">/</span>
						<span class="process">@yield('header')</span>
					</div>
					<div class="col-sm-2">
						<div class="anodyne-logo pull-right"></div>
					</div>
				</div>
			</div>
		</header>

		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<nav>
						<ol>
							<li class="step-completed">Database Connection</li>
							<li class="step-completed">Email Settings</li>
							<li class="step-active">Install Nova</li>
							<li>Create User</li>
							<li>Finalize</li>
						</ol>
					</nav>

					<footer>
						&copy; {{ Date::now()->year }} Anodyne Productions
					</footer>
				</div>
				<div class="col-md-9">
					<main>
						<div class="content">
							@if (Session::has('flash.message'))
								{!! flash() !!}
							@endif

							@yield('content')
						</div>

						<div class="controls">
							@yield('controls')
						</div>
					</main>
				</div>
			</div>
		</div>

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