<div id="app" class="container">
	<main>
		<div class="row">
			<div class="col-xs-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3">
				{!! partial('page-header', compact('_page')) !!}
				{!! $content or false !!}
			</div>
		</div>
	</main>
</div>