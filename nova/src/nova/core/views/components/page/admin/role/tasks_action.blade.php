<div class="btn-toolbar visible-lg">
	<div class="btn-group">
		<a href="{{ URL::to('admin/role/tasks') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

<div class="row hidden-lg">
	<div class="col-6 col-sm-4">
		<p><a href="{{ URL::to('admin/role/tasks') }}" class="btn btn-default btn-block icn-size-32">{{ $_icons['back'] }}</a></p>
	</div>
</div>

{{ Form::model($task) }}
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
		<div class="col-lg-6">
			<div class="control-group">
				<label class="control-label">{{ lang('Desc') }}</label>
				<div class="controls">
					{{ Form::textarea('desc', null, array('class' => 'input-with-feedback', 'rows' => 2)) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="{{ ($errors->has('component')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('Component') }}</label>
				<div class="controls">
					{{ Form::text('component', null, ['class' => 'input-with-feedback']) }}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('component', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.roles.chooseTaskComponent') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-lg-2">
			<div class="{{ ($errors->has('action')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('Action_proper') }}</label>
				<div class="controls">
					{{ Form::text('action', null, ['class' => 'input-with-feedback']) }}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('action', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.roles.chooseTaskAction') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 col-lg-1">
			<div class="{{ ($errors->has('level')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('Level') }}</label>
				<div class="controls">
					{{ Form::text('level', '0', ['class' => 'input-with-feedback']) }}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('level', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.roles.chooseTaskLevel') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('formAction', $action) }}
			{{ Form::hidden('id') }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}