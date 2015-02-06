<div class="container">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="{{ route('home') }}" class="navbar-brand">{{ config('nova.app.name') }}</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ route('setup.home') }}">Setup Center</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ route('login') }}">Log In</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<main>
		@if ($_page->header())
			<div class="page-header">
				<h1>{!! $_page->present()->header !!}</h1>
			</div>
		@endif

		@if ($_page->message())
			{!! $_page->present()->message !!}
		@endif

		{!! $content or '' !!}
	</main>

	<footer>
		{!! $footer or '' !!}
	</footer>
</div>