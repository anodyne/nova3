<div class="btn-toolbar">
	@if (Sentry::getUser()->hasAccess('settings.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/settings/create') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	@if (Sentry::getUser()->hasAccess('settings.update'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/settings') }}" class="btn btn-default icn-size-16">{{ $_icons['settings'] }}</a>
		</div>
	@endif
</div>