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
			<div class="control-group">
				<label class="control-label">{{ ucwords(lang('name')) }}</label>
				<div class="controls">
					{{ Form::text('name', null, array('class' => 'col-span-3 input-with-feedback')) }}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">{{ ucwords(lang('desc')) }}</label>
				<div class="controls">
					{{ Form::textarea('desc', null, array('class' => 'col-span-6 input-with-feedback', 'rows' => 4)) }}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">{{ ucwords(lang('action.inherits')) }}</label>
				<div class="controls">
					{{ Form::roles('inherits', explode(',', $role->inherits), array('class' => 'chzn col-span-6', 'multiple' => 'multiple'), true) }}
				</div>
			</div>

			<div class="controls">
				{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
			</div>
		{{ Form::close() }}
	</div>

	<div id="tasks" class="tab-pane">
		@if (count($tasks) > 0)
			@foreach ($tasks as $component => $task)
				<fieldset>
					<legend>{{ ucfirst($component) }}</legend>

					<div class="row">
					@foreach ($task as $t)
						<div class="col-span-3">
							<label class="checkbox">
								{{ Form::checkbox('tasks[]') }} {{ $t->name }}
								
								@if ( ! empty($t->desc))
									<span class="icn-opacity-50 tooltip-top" data-title="{{ $t->desc }}">{{ $_icons['question'] }}</span>
								@endif
							</label>
						</div>
					@endforeach
					</div>
				</fieldset>
			@endforeach
		@else
			<p class="alert">{{ lang('error.notFound', langConcat('tasks')) }}</p>
		@endif
	</div>
</div>