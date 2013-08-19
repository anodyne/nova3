<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/role') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($role) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">
					{{ Form::text('name', null, ['class' => 'input-with-feedback form-control']) }}
					{{ $errors->first('name', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-8 col-lg-6">
			<div class="form-group">
				<label class="control-label">{{ lang('Desc') }}</label>
				<div class="controls">
					{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="control-label">{{ lang('Action.inherits') }}</label>
				<div class="controls">
					<div class="row">
					@foreach ($roles as $r)
						@if ($action == 'update')
							@if ($r->id != $role->id)
								<div class="col-sm-6 col-lg-4">
									<label class="checkbox">
										{{ Form::checkbox('inherits[]', $r->id, (in_array($r->id, $role->inherits)), ['data-role' => $r->id, 'class' => 'js-inherited-roles']) }} {{ $r->name }}
									</label>
								</div>
							@endif
						@else
							<div class="col-sm-6 col-lg-4">
								<label class="checkbox">
									{{ Form::checkbox('inherits[]', $r->id, null, ['data-role' => $r->id, 'class' => 'js-inherited-roles']) }} {{ $r->name }}
								</label>
							</div>
						@endif
					@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<h2>{{ ucwords(langConcat('role tasks')) }}</h2>
		
	@if (count($tasks) > 0)
		<div class="visible-lg taskList">
			@foreach ($tasks as $component => $task)
				<fieldset>
					<legend>{{ ucfirst($component) }}</legend>

					<div class="row">
					@foreach ($task as $t)
						<div class="col-sm-6 col-lg-4">
							<label class="checkbox">
								@if (array_key_exists($t->id, $inheritedTasks))
									{{ Form::checkbox('tasks[]', $t->id, true, ['disabled' => 'disabled']) }}
								@elseif (array_key_exists($t->id, $roleTasks))
									{{ Form::checkbox('tasks[]', $t->id, true) }}
								@else
									{{ Form::checkbox('tasks[]', $t->id) }}
								@endif

								{{ $t->name }}
								
								<dl>
								@if ( ! empty($t->desc))
									<dd class="text-small text-muted">{{ $t->desc }}</dd>
								@endif

								@if (array_key_exists($t->id, $inheritedTasks))
									<dd class="text-small text-info">{{ lang('short.admin.roles.inheritedTask', $inheritedTasks[$t->id]['role']) }}</dd>
								@endif
								</dl>
							</label>
						</div>
					@endforeach
					</div>
				</fieldset>
			@endforeach
		</div>
		<div class="hidden-lg taskList">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel-group" id="accordion">
						<?php $i = 1;?>
						@foreach ($tasks as $component => $task)
							<div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $i }}">
										<h4 class="panel-title">{{ ucfirst($component) }}</h4>
									</a>
								</div>

								<div id="collapse{{ $i }}" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="row">
										@foreach ($task as $t)
											<div class="col-xs-12 col-sm-6">
												<label class="checkbox">
													@if (array_key_exists($t->id, $inheritedTasks))
														{{ Form::checkbox('tasks[]', $t->id, true, ['disabled' => 'disabled']) }}
													@elseif (array_key_exists($t->id, $roleTasks))
														{{ Form::checkbox('tasks[]', $t->id, true) }}
													@else
														{{ Form::checkbox('tasks[]', $t->id) }}
													@endif

													{{ $t->name }}
													
													@if ( ! empty($t->desc))
														<p class="text-small text-muted">{{ $t->desc }}</p>
													@endif

													@if (array_key_exists($t->id, $inheritedTasks))
														<p class="text-small text-info">{{ lang('short.admin.roles.inheritedTask', $inheritedTasks[$t->id]['role']) }}</p>
													@endif
												</label>
											</div>
										@endforeach
										</div>
									</div>
								</div>
							</div>
							<?php ++$i;?>
						@endforeach
					</div>
				</div>
			</div>

			<hr>
		</div>
	@else
		{{ partial('common/alert', ['content' => lang('error.notFound', lang('tasks'))]) }}
	@endif

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('action', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}