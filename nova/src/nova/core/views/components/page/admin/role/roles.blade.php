<div class="btn-toolbar">
	@if (Sentry::getUser()->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/role/tasks') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.manage', langConcat('access tasks')) }}">{{ $_icons['list'] }}</a>
	</div>
</div>

@if (count($roles) > 0)
	<table class="table table-striped">
		<tbody>
		@foreach ($roles as $r)
			<tr>
				<td class="col-alt-9">
					<p><strong>{{ $r->name }}</strong></p>
					<p class="text-muted text-small">{{ $r->desc }}</p>
				</td>
				<td class="col-alt-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default btn-small tooltip-top js-role-action icn-size-16" title="{{ lang('Short.view', langConcat('users with this role')) }}" data-action="view" data-id="{{ $r->id }}">{{ $_icons['view'] }}</a>
							
							<a href="{{ URL::to('admin/role/'.$r->id) }}" class="btn btn-default btn-small icn-size-16">{{ $_icons['edit'] }}</a>

							@if (Sentry::getUser()->hasAccess('role.create'))
								<a href="#" class="btn btn-default btn-small js-role-action icn-size-16" title="{{ lang('Short.duplicate', lang('role')) }}" data-action="duplicate" data-id="{{ $r->id }}">{{ $_icons['duplicate'] }}</a>
							@endif
						</div>

						@if (Sentry::getUser()->hasAccess('role.delete'))
							<div class="btn-group">
								<a href="#" class="btn btn-small btn-danger js-role-action icn-size-16" data-action="delete" data-id="{{ $r->id }}">{{ $_icons['remove'] }}</a>
							</div>
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('access roles'))]) }}
@endif