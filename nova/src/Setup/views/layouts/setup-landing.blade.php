<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title') &bull; {{ config('nova.app.name') }}</title>
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500,700" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		{!! HTML::style('nova/src/Setup/views/design/css/setup.style.css') !!}
		{!! HTML::style('nova/src/Setup/views/design/css/setup.responsive.css') !!}
	</head>
	<body>
		<header>
			<div class="container">
				<div class="header">
					<div class="header-group">
						@icon('nova/src/Setup/views/design/images/anodyne', ['class' => 'brand'])
					</div>

					<div class="header-group">
						<div class="masthead">
							<span class="product">{{ config('nova.app.name') }} Setup</span>
							<span class="divider">/</span>
							<span class="process">@yield('header')</span>
						</div>
					</div>
				</div>
			</div>
		</header>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-xl-10 offset-xl-1">
						{!! display_flash_message() !!}

						@yield('content')
					</div>
				</div>
			</div>
		</section>

		<footer>
			<div class="container">
				&copy; {{ Date::now()->year }} Anodyne Productions
			</div>
		</footer>
	</body>
</html>