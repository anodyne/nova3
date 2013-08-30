<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/role/tasks') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($task) }}
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
		<div class="col-sm-10 col-lg-6">
			<div class="form-group">
				<label class="control-label">{{ lang('Desc') }}</label>
				<div class="controls">
					{{ Form::textarea('desc', null, array('class' => 'input-with-feedback form-control', 'rows' => 5)) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="{{ ($errors->has('component')) ? 'form-group has-error' : '' }}">
				<label class="control-label">{{ lang('Component') }}</label>
				<div class="controls">
					{{ Form::text('component', null, ['class' => 'input-with-feedback form-control']) }}
					{{ $errors->first('component', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.roles.chooseTaskComponent') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="{{ ($errors->has('action')) ? 'form-group has-error' : '' }}">
				<label class="control-label">{{ lang('Action_proper') }}</label>
				<div class="controls">
					{{ Form::text('action', null, ['class' => 'input-with-feedback form-control']) }}
					{{ $errors->first('action', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.roles.chooseTaskAction') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-6 col-sm-2 col-lg-2">
			<div class="{{ ($errors->has('level')) ? 'form-group has-error' : '' }}">
				<label class="control-label">{{ lang('Level') }}</label>
				<div class="controls">
					{{ Form::text('level', '0', ['class' => 'input-with-feedback form-control']) }}
					{{ $errors->first('level', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.roles.chooseTaskLevel') }}</p>
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