<div class="btn-toolbar visible-lg">
	@if (Sentry::getUser()->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/tasks/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	@if (Sentry::getUser()->hasAccess('role.update'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.manage', langConcat('access roles')) }}">{{ $_icons['lock'] }}</a>
		</div>
	@endif
</div>

<div class="row hidden-lg">
	@if (Sentry::getUser()->hasAccess('role.create'))
		<div class="col-6">
			<p><a href="{{ URL::to('admin/role/tasks/0') }}" class="btn btn-success btn-block icn-size-16">{{ $_icons['add'] }}</a></p>
		</div>
	@endif

	@if (Sentry::getUser()->hasAccess('role.update'))
		<div class="col-6">
			<p><a href="{{ URL::to('admin/role') }}" class="btn btn-default btn-block icn-size-16">{{ $_icons['lock'] }}</a></p>
		</div>
	@endif
</div>

@if (count($tasks) > 0)
	<div class="row">
		<div class="col-lg-4">
			<div class="control-group">
				<div class="controls">
					{{ Form::text('user_search', null, ['class' => 'search-query', 'id' => 'userSearch', 'placeholder' => lang('Short.search', langConcat('for access tasks'))]) }}
				</div>
			</div>
		</div>
	</div>
	
	<div class="visible-lg">
		@foreach ($tasks as $component => $task)
			<h3>{{ ucfirst($component) }}</h3>

			<table class="table table-striped">
				<tbody>
				@foreach ($task as $t)
					<tr>
						<td class="col-alt-9">
							<p><strong>{{ $t->name }}</strong></p>
							<p class="text-muted text-small">{{ $t->desc }}</p>
						</td>
						<td class="col-alt-3">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default btn-small tooltip-top js-task-action icn-size-16" title="{{ ucfirst(lang('short.view', langConcat('roles with this task'))) }}" data-action="view" data-id="{{ $t->id }}">{{ $_icons['view'] }}</a>
									
									@if (Sentry::getUser()->hasAccess('role.update'))
										<a href="{{ URL::to('admin/role/tasks/'.$t->id) }}" class="btn btn-default btn-small icn-size-16">{{ $_icons['edit'] }}</a>
									@endif
								</div>

								@if (Sentry::getUser()->hasAccess('role.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-small btn-danger js-task-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endforeach
	</div>

	<div class="hidden-lg">
		<div class="row">
		@foreach ($tasks as $component => $task)
			<div class="col-12">
				<div class="thumbnail">
					<h3>{{ ucfirst($component) }}</h3>

					<div class="row">
					@foreach ($task as $t)
						<div class="col-12">
							<h4>{{ $t->name }}</h4>
							<p class="text-muted text-small">{{ $t->desc }}</p>

							<div class="row">
								<div class="col-6">
									<p><a href="#" class="btn btn-default btn-block js-task-action icn-size-16" data-action="view" data-id="{{ $t->id }}">{{ $_icons['view'] }}</a></p>
								</div>
									
								@if (Sentry::getUser()->hasAccess('role.update'))
									<div class="col-6">
										<p><a href="{{ URL::to('admin/role/tasks/'.$t->id) }}" class="btn btn-default btn-block icn-size-16">{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('role.delete'))
									<div class="col-12">
										<p><a href="#" class="btn btn-block btn-danger js-task-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a></p>
									</div>
								@endif
							</div>
						</div>
					@endforeach
					</div>
				</div>
			</div>
		@endforeach
		</div>
	</div>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('access tasks'))]) }}
@endif