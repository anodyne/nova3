<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/sitecontent') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($content, ['url' => 'admin/sitecontent']) }}
	<div class="row">
		<div class="col-lg-2">
			<div class="form-group">
				<label class="control-label">{{ lang('Type') }}</label>
				{{ Form::select('type', ['header' => lang('Header'), 'title' => lang('Title'), 'message' => lang('Message'), 'email' => lang('Email_short'), 'other' => lang('Other')], null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="form-group{{ ($errors->has('label')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Label') }}</label>
				{{ Form::text('label', null, ['class' => 'form-control input-with-feedback']) }}
				{{ $errors->first('label', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Key') }}</label>
				{{ Form::text('key', null, ['class' => 'form-control']) }}
				{{ $errors->first('key', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="control-label">{{ lang('Content') }}</label>
				{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-2">
			<div class="form-group">
				<label class="control-label">{{ lang('Mode') }}</label>
				{{ Form::select('mode', ['' => lang('short.admin.content.noMode'), 'create' => lang('Action.create'), 'update' => lang('Action.update'), 'delete' => lang('Action.delete')], null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row" id="uriField">
		<div class="col-lg-4">
			<div class="form-group{{ ($errors->has('uri')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('uri') }}</label>
				{{ Form::text('uri', null, ['class' => 'form-control']) }}
				{{ $errors->first('uri', '<p class="help-block typeahead-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('formAction', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}