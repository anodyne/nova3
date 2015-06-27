<div class="container">
	<main>
		<div class="row">
			<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
				{!! partial('page-header', compact('_page')) !!}

				{!! display_flash_message() !!}

				{!! partial('page-message', compact('_page')) !!}

				{!! $content or false !!}
			</div>
		</div>
	</main>
</div>