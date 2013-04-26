<div class="btn-group">
	<a href="{{ URL::to('admin/role/index') }}" class="btn icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.back', langConcat('access roles'))) }}">{{ $_icons['back'] }}</a>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#role" data-toggle="tab">{{ ucwords(langConcat('basic info')) }}</a></li>
	<li><a href="#tasks" data-toggle="tab">{{ ucwords(lang('tasks')) }}</a></li>
</ul>

<div class="tab-content">
	<div id="role" class="tab-pane active">
		{{ Form::model($role, array('url' => 'admin/role/index')) }}
			<div class="row">
				<div class="col-span-4">
					<div class="control-group">
						<label class="control-label">{{ ucwords(lang('name')) }}</label>
						<div class="controls">
							{{ Form::text('name', null, array('class' => 'input-with-feedback')) }}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-span-8">
					<div class="control-group">
						<label class="control-label">{{ ucwords(lang('desc')) }}</label>
						<div class="controls">
							{{ Form::textarea('desc', null, array('class' => 'input-with-feedback', 'rows' => 3)) }}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-span-8">
					<div class="control-group">
						<label class="control-label">{{ ucwords(lang('action.inherits')) }}</label>
						<div class="controls">
							{{ Form::roles('inherits', null, array('class' => 'chzn', 'multiple' => 'multiple'), true) }}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-span-4">
					<div class="controls">
						{{ Form::hidden('id') }}
						{{ Form::hidden('action', $action) }}
						{{ Form::hidden('_token', csrf_token()) }}
						
						{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
					</div>
				</div>
			</div>
		{{ Form::close() }}
	</div>

	<div id="tasks" class="tab-pane">
		@if (count($tasks) > 0)
			{{ Form::open(array('url' => 'admin/role/index')) }}
				@foreach ($tasks as $component => $task)
					<fieldset>
						<legend>{{ ucfirst($component) }}</legend>

						<div class="row">
						@foreach ($task as $t)
							<div class="col-span-4">
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
										<span class="icn-opacity-50 tooltip-top" data-title="{{ lang('short.roles.inheritedTask') }}">{{ $_icons['info'] }}</span>
									@endif
								</label>
							</div>
						@endforeach
						</div>
					</fieldset>
				@endforeach

				<div class="row">
					<div class="col-span-4">
						<div class="controls">
							{{-- Form::hidden('id', $role->id) --}}
							{{ Form::hidden('action', 'updateTasks') }}
							{{ Form::hidden('_token', csrf_token()) }}
							
							{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
						</div>
					</div>
				</div>
			{{ Form::close() }}
		@else
			<p class="alert">{{ lang('error.notFound', langConcat('tasks')) }}</p>
		@endif
	</div>
</div>