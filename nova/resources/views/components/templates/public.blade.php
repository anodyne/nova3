<div id="app" class="container">
	{!! $publicMenuCombined or false !!}

	<main>
		{!! partial('page-header', compact('_page')) !!}
		{!! partial('page-message', compact('_page')) !!}

		{!! $content or false !!}
	</main>

	<footer>
		{!! $footer or false !!}
	</footer>

	{!! partial('panel') !!}
</div>