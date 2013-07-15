<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/catalog') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	@if (Sentry::getUser()->hasAccess('catalog.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/catalog/ranks/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif
</div>