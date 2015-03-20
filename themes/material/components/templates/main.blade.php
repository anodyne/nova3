{!! $nav or '' !!}

<header>
	<div class="container">
		<h1>{{ $_settings->sim_name }}</h1>
	</div>
</header>

<div class="container">
	<main>
		@if (Session::has('flash.level'))
			{!! flash() !!}
		@endif
		
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
</div>

<footer>
	<div class="container">
		{!! $footer or '' !!}
	</div>
</footer>