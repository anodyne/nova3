<div class="navbar navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="{{ URL::to('/') }}" class="navbar-brand">{{ $settings->sim_name }}</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-10 col-lg-6 col-sm-offset-1 col-lg-offset-3">
			<div class="page-header">
				<h1>{{ $header }}</h1>
			</div>

			{{ $flash }}

			<p>{{ $message }}</p>

			{{ $content }}

			<footer>
				&copy; {{ Date::now()->year }} <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a>
			</footer>
		</div>
	</div>
</div>