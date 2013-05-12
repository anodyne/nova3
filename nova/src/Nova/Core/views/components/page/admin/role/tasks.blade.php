@if (count($tasks) > 0)
	<div class="controls pull-right">
		<input type="text" id="user-search" class="search-query" placeholder="{{ ucfirst(lang('short.search', langConcat('for access tasks'))) }}">
	</div>
@endif

<div class="btn-toolbar">
	@if (Sentry::getUser()->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/tasks/0') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.add', langConcat('access task'))) }}">{{ $_icons['add'] }}</a>
		</div>
	@endif

	@if (Sentry::getUser()->hasAccess('role.update'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/index') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.manage', langConcat('access roles'))) }}">{{ $_icons['lock'] }}</a>
		</div>
	@endif
</div>

@if (count($tasks) > 0)
	@foreach ($tasks as $component => $task)
		<h3>{{ ucfirst($component) }}</h3>

		<table class="table table-striped">
			<tbody>
			@foreach ($task as $t)
				<tr>
					<td class="col col-lg-9">
						<p><strong>{{ $t->name }}</strong></p>
						<p class="text-muted text-small">{{ $t->desc }}</p>
					</td>
					<td class="col col-lg-3">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="#" class="btn btn-default btn-small tooltip-top js-task-action icn-size-16" title="{{ ucfirst(lang('short.view', langConcat('roles with this task'))) }}" data-action="view" data-id="{{ $t->id }}">{{ $_icons['view'] }}</a>
								
								@if (Sentry::getUser()->hasAccess('role.update'))
									<a href="{{ URL::to('admin/role/tasks/'.$t->id) }}" class="btn btn-default btn-small tooltip-top icn-size-16" title="{{ ucfirst(lang('short.edit', lang('task'))) }}">{{ $_icons['edit'] }}</a>
								@endif
							</div>

							@if (Sentry::getUser()->hasAccess('role.delete'))
								<div class="btn-group">
									<a href="#" class="btn btn-small btn-danger tooltip-top js-task-action icn-size-16" title="{{ ucfirst(lang('short.delete', lang('task'))) }}" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a>
								</div>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endforeach
@else
	<p class="alert">{{ lang('error.notFound', langConcat('access tasks')) }}</p>
@endif