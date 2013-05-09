<div class="btn-group">
	<a href="{{ URL::to('admin/role/index') }}" class="btn icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.back', langConcat('access roles'))) }}">{{ $_icons['back'] }}</a>
</div>

{{ Form::model($role, array('url' => 'admin/role/index')) }}
	<div class="row">
		<div class="col col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ ucwords(lang('name')) }}</label>
				<div class="controls">
					{{ Form::text('name', null, array('class' => 'input-with-feedback')) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-8">
			<div class="control-group">
				<label class="control-label">{{ ucwords(lang('desc')) }}</label>
				<div class="controls">
					{{ Form::textarea('desc', null, array('class' => 'input-with-feedback', 'rows' => 4)) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-8">
			<div class="control-group">
				<label class="control-label">{{ ucwords(lang('action.inherits')) }}</label>
				<div class="controls">
					<div class="row">
					@foreach ($roles as $r)
						<div class="col col-lg-6">
							<label class="checkbox">
								@if ($action == 'update')
									{{ Form::checkbox('inherits[]', $r->id, (in_array($r->id, $role->inherits)), array('data-role' => $r->id, 'class' => 'js-inherited-roles')) }} {{ $r->name }}
								@else
									{{ Form::checkbox('inherits[]', $r->id, null, array('data-role' => $r->id, 'class' => 'js-inherited-roles')) }} {{ $r->name }}
								@endif
							</label>
						</div>
					@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<h2>{{ ucwords(langConcat('role tasks')) }}</h2>
		
	@if (count($tasks) > 0)
		<div class="hidden-phone taskList">
			@foreach ($tasks as $component => $task)
				<fieldset>
					<legend>{{ ucfirst($component) }}</legend>

					<div class="row">
					@foreach ($task as $t)
						<div class="col col-lg-4">
							<label class="checkbox">
								@if (array_key_exists($t->id, $inheritedTasks))
									{{ Form::checkbox('tasks[]', $t->id, true, array('disabled' => 'disabled')) }}
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

		<div class="visible-phone taskList">
			<div class="row">
				<div class="col col-sm-12">
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
													{{ Form::checkbox('tasks[]', $t->id, true, array('disabled' => 'disabled')) }}
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
		<p class="alert">{{ lang('error.notFound', langConcat('tasks')) }}</p>
	@endif

	<div class="row">
		<div class="col col-lg-4">
			<div class="controls">
				{{ Form::hidden('id') }}
				{{ Form::hidden('action', $action) }}
				{{ Form::hidden('_token', csrf_token()) }}
				
				{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
			</div>
		</div>
	</div>
{{ Form::close() }}