<div id="app" class="container">
	{!! $menuCombined or false !!}

	<main>
		{!! partial('page-header', compact('_page')) !!}

		{!! partial('page-message', compact('_page')) !!}

		{!! $content or false !!}
	</main>

	<footer>
		{!! $footer or false !!}
	</footer>
</div>