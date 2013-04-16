<div class="btn-toolbar">
	@if (Sentry::user()->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/index/0') }}" class="btn icn16 tooltip-top" title="{{ ucfirst(lang('short.add', langConcat('access role'))) }}"><div class="icn icn-75" data-icon="+"></div></a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/role/tasks') }}" class="btn icn16 tooltip-top" title="{{ ucfirst(lang('short.manage', langConcat('access tasks'))) }}"><div class="icn icn-75" data-icon=","></div></a>
	</div>
</div>

@if (count($roles) > 0)
	<table class="table table-striped">
		<tbody>
		@foreach ($roles as $r)
			<tr>
				<td>
					<span class="lead">{{ $r->name }}</span><br>
					<span class="muted">{{ Markdown::parse($r->desc) }}</span>
				</td>
				<td class="span3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-small tooltip-top role-action icn16" title="{{ ucfirst(lang('short.view', langConcat('users with this role'))) }}" data-action="view" data-id="{{ $r->id }}"><div class="icn icn-50" data-icon="s"></div></a>
							<a href="{{ URL::to('admin/role/edit/'.$r->id) }}" class="btn btn-small tooltip-top icn16" title="{{ ucfirst(lang('short.edit', lang('role'))) }}"><div class="icn icn-50" data-icon="p"></div></a>

							@if (Sentry::user()->hasAccess('role.create'))
								<a href="#" class="btn btn-small tooltip-top role-action icn16" title="{{ ucfirst(lang('short.duplicate', lang('role'))) }}" data-action="duplicate" data-id="{{ $r->id }}"><div class="icn icn-50" data-icon="_"></div></a>
							@endif
						</div>

						@if (Sentry::user()->hasAccess('role.delete'))
							<div class="btn-group">
								<a href="#" class="btn btn-small btn-danger tooltip-top role-action icn16" title="{{ ucfirst(lang('short.delete', lang('role'))) }}" data-action="delete" data-id="{{ $r->id }}"><div class="icn icn-50" data-icon="t"></div></a>
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