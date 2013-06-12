<div class="navbar navbar-fixed-top">
	<div class="container">
		{{ HTML::link('/', $settings->sim_name, ['class' => 'navbar-brand']) }}
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-6 col-lg-6 col-offset-3">
			<div class="page-header">
				<h1>{{ $header }}</h1>
			</div>

			{{ $flash }}

			<p>{{ $message }}</p>

			{{ $content }}

			<footer>
				&copy; {{ Date::now()->year }} Anodyne Productions
			</footer>
		</div>
	</div>
</div>