<div id="app" class="container">
	{!! $adminMenuCombined or false !!}

	<main>
		{!! partial('page-header', compact('_page')) !!}
		{!! $content or false !!}
	</main>

	<footer>
		{!! $footer or false !!}
	</footer>
</div>