<div id="app" class="container">
	<main>
		<div class="row">
			<div class="col-sm-8 col-md-6 offset-sm-2 offset-md-3">
				{!! partial('page-header', compact('_page')) !!}
				{!! partial('page-message', compact('_page')) !!}

				{!! $content or false !!}
			</div>
		</div>
	</main>
</div>