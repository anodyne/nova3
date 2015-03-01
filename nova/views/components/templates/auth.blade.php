<div class="container">
	<main>
		<div class="row">
			<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
				@if ($_page->header())
					<div class="page-header">
						<h1>{!! $_page->present()->header !!}</h1>
					</div>
				@endif

				@if (Session::has('flash.level'))
					{!! flash() !!}
				@endif

				@if ($_page->message())
					{!! $_page->present()->message !!}
				@endif

				{!! $content or '' !!}
			</div>
		</div>
	</main>
</div>