<div class="navbar navbar-default navbar-fixed-top visible-xs">
	<div class="container">
		<div class="navbar-header">
			<a href="{{ URL::to('/') }}" class="navbar-brand">{{ $settings->sim_name }}</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-10 col-lg-6 col-sm-offset-1 col-lg-offset-3">
			<div class="hidden-xs">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="pane-title">{{ $settings->sim_name }}</h4>
					</div>
					<div class="panel-body">
						<h1>{{ $header }}</h1>

						{{ $flash }}

						<p>{{ $message }}</p>

						{{ $content }}
					</div>
				</div>
			</div>
			<div class="visible-xs">
				<div class="page-header">
					<h1>{{ $header }}</h1>
				</div>

				{{ $flash }}

				<p>{{ $message }}</p>

				{{ $content }}
			</div>

			<footer>
				&copy; {{ Date::now()->year }} <a href="http://anodyne-productions.com" target="_blank">Anodyne Productions</a>
			</footer>
		</div>
	</div>
</div>