<div class="flex items-center h-screen">
	<div class="w-1/3 flex flex-col h-screen px-12 justify-center">
		{!! $template ?? false !!}
	</div>

	<div class="flex-1 h-screen bg-no-repeat bg-center bg-cover" style="background-image:url({{ $image }})"></div>
</div>