{!! $menuCombined or false !!}

<header>
	<div class="container">
		<h1>{{ $_settings->get('sim_name') }}</h1>
	</div>
</header>

<div class="container">
	<main>
		{!! partial('page-header', compact('_page')) !!}

		{!! partial('page-message', compact('_page')) !!}

		{!! $content or false !!}
	</main>
</div>

<footer>
	<div class="container">
		{!! $footer or false !!}
	</div>
</footer>