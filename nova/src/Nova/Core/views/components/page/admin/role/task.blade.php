<div class="btn-group">
	<a href="{{ URL::to('admin/role/tasks') }}" class="btn icn-size-16 tooltip-top" title="{{ ucfirst(lang('short.back', langConcat('access tasks'))) }}">{{ $_icons['back'] }}</a>
</div>

{{ Form::model($task) }}
	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang('name')) }}</label>
		<div class="controls">
			{{ Form::text('name', null, array('class' => 'col col-lg-4 input-with-feedback')) }}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang('desc')) }}</label>
		<div class="controls">
			{{ Form::textarea('desc', null, array('class' => 'col col-lg-6 input-with-feedback', 'rows' => 4)) }}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang('component')) }}</label>
		<div class="controls">
			{{ Form::text('component', null, array('class' => 'col col-lg-2 input-with-feedback', 'data-provide' => 'typeahead', 'data-source' => $componentSource)) }}
			<p class="help-block">{{ lang('short.roles.chooseTaskComponent') }}</p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang('action_proper')) }}</label>
		<div class="controls">
			{{ Form::text('action', null, array('class' => 'col col-lg-2 input-with-feedback', 'data-provide' => 'typeahead', 'data-source' => $actionSource)) }}
			<p class="help-block">{{ lang('short.roles.chooseTaskAction') }}</p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang('level')) }}</label>
		<div class="controls">
			{{ Form::text('level', null, array('class' => 'col col-lg-1 input-with-feedback')) }}
			<p class="help-block">{{ lang('short.roles.chooseTaskLevel') }}</p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang('dependencies')) }}</label>
		<div class="controls">
			{{ Form::textarea('dependencies', null, array('class' => 'col col-lg-6 input-with-feedback')) }}
			<p class="help-block">{{ lang('short.roles.chooseTaskDependencies') }}</p>
		</div>
	</div>

	<div class="controls">
		{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
	</div>

	{{ Form::hidden('action', $action) }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('_token', csrf_token()) }}
{{ Form::close() }}