<div class="btn-toolbar">
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

@if (count($tasks) > 0)
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="control-group">
				{{ Form::text('', null, ['id' => 'searchTasks', 'placeholder' => lang('Short.search', langConcat('for Access Tasks')), 'class' => 'form-control']) }}
			</div>
		</div>
	</div>

	@foreach ($tasks as $component => $task)
		<h3>{{ ucfirst($component) }}</h3>

		<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="taskSearch">
			@foreach ($task as $t)
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<p><strong>{{ $t->name }}</strong></p>
						<p class="text-muted text-small">{{ $t->desc }}</p>
					</div>
					<div class="col-xs-12 col-sm-4 col-lg-3">
						<div class="hidden-xs">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-default tooltip-top js-task-action icn-size-16" title="{{ ucfirst(lang('short.view', langConcat('roles with this task'))) }}" data-action="view" data-id="{{ $t->id }}">{{ $_icons['view'] }}</a>
									
									@if (Sentry::getUser()->hasAccess('role.update'))
										<a href="{{ URL::to('admin/role/tasks/'.$t->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
									@endif
								</div>

								@if (Sentry::getUser()->hasAccess('role.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-sm btn-danger js-task-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="visible-xs">
							<div class="row">
								<div class="col-xs-6">
									<p><a href="#" class="btn btn-block btn-default js-task-action icn-size-16"  data-action="view" data-id="{{ $t->id }}">{{ $_icons['view'] }}</a></p>
								</div>
									
								@if (Sentry::getUser()->hasAccess('role.update'))
									<div class="col-xs-6">
										<p><a href="{{ URL::to('admin/role/tasks/'.$t->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('role.delete'))
									<div class="col-xs-12">
										<p><a href="#" class="btn btn-block btn-danger js-task-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a></p>
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