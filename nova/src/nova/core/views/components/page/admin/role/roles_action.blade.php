<div class="btn-group">
	<a href="{{ URL::to('admin/role') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
</div>

{{ Form::model($role) }}
	<div class="row">
		<div class="col-lg-4">
			<div class="control-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">
					{{ Form::text('name', null, ['class' => 'input-with-feedback']) }}
					{{ $errors->first('name', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-8">
			<div class="control-group">
				<label class="control-label">{{ lang('Desc') }}</label>
				<div class="controls">
					{{ Form::textarea('desc', null, ['class' => 'input-with-feedback', 'rows' => 4]) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-8">
			<div class="control-group">
				<label class="control-label">{{ lang('Action.inherits') }}</label>
				<div class="controls">
					<div class="row">
					@foreach ($roles as $r)
						@if ($action == 'update')
							@if ($r->id != $role->id)
								<div class="col-lg-6">
									<label class="checkbox">
										{{ Form::checkbox('inherits[]', $r->id, (in_array($r->id, $role->inherits)), ['data-role' => $r->id, 'class' => 'js-inherited-roles']) }} {{ $r->name }}
									</label>
								</div>
							@endif
						@else
							<div class="col-lg-6">
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
		<div class="hidden-sm taskList">
			@foreach ($tasks as $component => $task)
				<fieldset>
					<legend>{{ ucfirst($component) }}</legend>

					<div class="row">
					@foreach ($task as $t)
						<div class="col-lg-4">
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
									<span class="icn-opacity-50 tooltip-top" data-title="{{ $t->desc }}">{{ $_icons['question'] }}</span>
								@endif

								@if (array_key_exists($t->id, $inheritedTasks))
									<span class="icn-opacity-50 tooltip-top" data-title="{{ lang('short.roles.inheritedTask', $inheritedTasks[$t->id]['role']) }}">{{ $_icons['info'] }}</span>
								@endif
							</label>
						</div>
					@endforeach
					</div>
				</fieldset>
			@endforeach
		</div>

		<div class="visible-sm taskList">
			<div class="row">
				<div class="col-sm-12">
					<div class="accordion" id="accordion">
						<?php $i = 1;?>
						@foreach ($tasks as $component => $task)
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $i }}">
										<div class="pull-right glyphicon glyphicon-chevron-down"></div>
										{{ ucfirst($component) }}
									</a>
								</div>

								<div id="collapse{{ $i }}" class="accordion-body collapse">
									<div class="accordion-inner">
										@foreach ($task as $t)
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
													<p class="text-small text-muted">{{ lang('short.roles.inheritedTask', $inheritedTasks[$t->id]['role']) }}</p>
												@endif
											</label>
										@endforeach
									</div>
								</div>
							</div>
							<?php ++$i;?>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	@else
		{{ partial('common/alert', ['content' => lang('error.notFound', lang('tasks'))]) }}
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}