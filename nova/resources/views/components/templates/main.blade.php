<div class="container">
	{!! $menuCombined or false !!}

	<main>
		{!! display_flash_message() !!}

		{!! partial('page-header', compact('_page')) !!}

		{!! partial('page-message', compact('_page')) !!}

		{!! $content or false !!}
	</main>

	<footer>
		{!! $footer or false !!}
	</footer>
</div>