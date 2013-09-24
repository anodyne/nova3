<div class="btn-toolbar">
	@if ($_currentUser->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/tasks/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	@if ($_currentUser->hasAccess('role.update'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.manage', langConcat('access roles')) }}">{{ $_icons['lock'] }}</a>
		</div>
	@endif
</div>

@if (count($tasks) > 0)
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="form-group">
				{{ Form::text('', null, ['id' => 'searchTasks', 'placeholder' => lang('Short.search', langConcat('for Access Tasks')), 'class' => 'form-control']) }}
			</div>
		</div>
	</div>

	@foreach ($tasks as $component => $taskList)
		<h3>{{ ucfirst($component) }}</h3>

		<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="taskSearch">
			@foreach ($taskList as $task)
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-9">
						<p><strong>{{ $task->name }}</strong></p>
						<p class="text-muted text-small">{{ $task->desc }}</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-lg-3">
						<div class="visible-lg">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-default tooltip-top js-task-action icn-size-16" title="{{ ucfirst(lang('short.view', langConcat('roles with this task'))) }}" data-action="view" data-id="{{ $task->id }}">{{ $_icons['view'] }}</a>
								</div>

								@if ($_currentUser->hasAccess('role.update'))
									<div class="btn-group">
										<a href="{{ URL::to('admin/role/tasks/'.$task->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
									</div>
								@endif

								@if ($_currentUser->hasAccess('role.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-sm btn-danger js-task-action icn-size-16" data-action="delete" data-id="{{ $task->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="hidden-lg">
							<div class="row">
								<div class="col-xs-12 col-sm-4">
									<p><a href="#" class="btn btn-block btn-default js-task-action icn-size-16"  data-action="view" data-id="{{ $task->id }}">{{ $_icons['view'] }}</a></p>
								</div>
									
								@if ($_currentUser->hasAccess('role.update'))
									<div class="col-xs-12 col-sm-4">
										<p><a href="{{ URL::to('admin/role/tasks/'.$task->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if ($_currentUser->hasAccess('role.delete'))
									<div class="col-xs-12 col-sm-4">
										<p><a href="#" class="btn btn-block btn-danger js-task-action icn-size-16" data-action="delete" data-id="{{ $task->id }}">{{ $_icons['remove'] }}</a></p>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@endforeach
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('access tasks'))]) }}
@endif