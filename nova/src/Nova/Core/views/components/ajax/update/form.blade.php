{{ Form::model($form, ['url' => 'admin/form']) }}
	<div class="row">
		<div class="col col-lg-6">
			<label class="control-label">{{ lang('Name') }}</label>
			{{ Form::text('name') }}
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-6">
			<label class="control-label">{{ langConcat('Form Key') }}</label>
			{{ Form::text('key') }}
		</div>
	</div>	
	<div class="row">
		<div class="col col-lg-12 has-error">
			<p class="help-block">{{ lang('short.admin.forms.changeFormKey') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-6">
			<label class="control-label">{{ lang('Orientation') }}</label>
			{{ Form::select('orientation', ['vertical' => lang('Vertical'), 'horizontal' => lang('Horizontal')]) }}
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-6">
			<label class="control-label">{{ lang('Status') }}</label>
			{{ Form::select('status', [Status::ACTIVE => lang('Active'), Status::INACTIVE => lang('Inactive')]) }}
		</div>
	</div>
	
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}