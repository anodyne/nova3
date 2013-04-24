<div class="btn-toolbar">
	@if (Sentry::getUser()->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/index/0') }}" class="btn icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.add', langConcat('access role'))) }}">{{ $_icons['add'] }}</a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/role/tasks') }}" class="btn icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.manage', langConcat('access tasks'))) }}">{{ $_icons['categories'] }}</a>
	</div>
</div>

@if (count($roles) > 0)
	<table class="table table-striped">
		<tbody>
		@foreach ($roles as $r)
			<tr>
				<td class="col-span-9">
					<p><strong>{{ $r->name }}</strong></p>
					<p class="text-muted text-small">{{ $r->desc }}</p>
				</td>
				<td class="col-span-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-small tooltip-top js-role-action icn-size-16" title="{{ ucfirst(lang('short.view', langConcat('users with this role'))) }}" data-action="view" data-id="{{ $r->id }}">{{ $_icons['view'] }}</a>
							
							<a href="{{ URL::to('admin/role/index/'.$r->id) }}" class="btn btn-small tooltip-top icn-size-16" title="{{ ucfirst(lang('short.edit', lang('role'))) }}">{{ $_icons['edit'] }}</a>

							@if (Sentry::getUser()->hasAccess('role.create'))
								<a href="#" class="btn btn-small tooltip-top js-role-action icn-size-16" title="{{ ucfirst(lang('short.duplicate', lang('role'))) }}" data-action="duplicate" data-id="{{ $r->id }}">{{ $_icons['duplicate'] }}</a>
							@endif
						</div>

						@if (Sentry::getUser()->hasAccess('role.delete'))
							<div class="btn-group">
								<a href="#" class="btn btn-small btn-danger tooltip-top js-role-action icn-size-16" title="{{ ucfirst(lang('short.delete', lang('role'))) }}" data-action="delete" data-id="{{ $r->id }}">{{ $_icons['remove'] }}</a>
							</div>
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@else
	<p class="alert">{{ lang('error.notFound', langConcat('access roles')) }}</p>
@endif