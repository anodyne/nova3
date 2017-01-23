<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title') &bull; {{ config('nova.app.name') }}</title>
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">

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

		<div class="container" id="app">
			<main>
				<div class="content">
					{!! view('partials.steps-'.$_setupType) !!}

					{!! display_flash_message() !!}

					@yield('content')
				</div>

				<div class="controls">
					@yield('controls')
				</div>
			</main>
		</div>

		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		{!! HTML::script('nova/resources/js/functions.js') !!}
		{!! HTML::script('nova/resources/js/vue/components.js') !!}
		{!! HTML::script('nova/resources/js/vue/filters.js') !!}
		<script>
			var app = {}
		</script>
		@yield('scripts')
		<script>
			var vm = new Vue({
				el: '#app',
				mixins: [app]
			})
		</script>
	</body>
</html>