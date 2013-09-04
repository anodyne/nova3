<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($form, ['url' => 'admin/form']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group">
				<label class="control-label">{{ lang('Name') }}</label>
				{{ Form::text('name', null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ langConcat('Form Key') }}</label>
			{{ Form::text('key', null, ['class' => 'form-control']) }}
		</div>
	</div>	
	<div class="row">
		<div class="col-lg-12 has-error">
			<p class="help-block">{{ lang('short.admin.forms.changeFormKey') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5 col-lg-3">
			<div class="form-group">
				<label class="control-label">{{ lang('Orientation') }}</label>
				{{ Form::select('orientation', ['vertical' => lang('Vertical'), 'horizontal' => lang('Horizontal')], null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5 col-lg-3">
			<div class="form-group">
				<label class="control-label">{{ lang('Status') }}</label>
				{{ Form::select('status', [Status::ACTIVE => lang('Active'), Status::INACTIVE => lang('Inactive')], null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ ucwords(lang('Data_model')) }}</label>
			{{ Form::text('data_model', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.forms.dataModel') }}</p>
		</div>
	</div>

	@if ($action == 'create' or ($action == 'update' and (bool) $form->protected === false))
		<fieldset>
			<legend>{{ lang('short.admin.forms.formViewer') }}</legend>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label class="control-label">{{ lang('short.admin.forms.useFormViewer') }}</label>
					<div>
						<label class="radio-inline">{{ Form::radio('form_viewer', 1) }} {{ lang('Yes') }}</label>
						<label class="radio-inline">{{ Form::radio('form_viewer', 0) }} {{ lang('No') }}</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.useFormViewerHelp') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8 col-lg-6">
					<label class="control-label">{{ lang('Instructions') }}</label>
					{{ Form::textarea('form_viewer_message', null, ['rows' => 5, 'class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.formViewerMessageHelp') }}</p>
				</div>
			</div>

			@if ($action == 'update')
				<div class="row">
					<div class="col-sm-6 col-lg-4">
						<label class="control-label">{{ lang('short.admin.forms.formViewerDisplay') }}</label>
						{{ Form::select('form_viewer_display', $formFields, null, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<p class="help-block">{{ lang('short.admin.forms.formViewerDisplayHelp') }}</p>
					</div>
				</div>
			@endif
		</fieldset>

		<fieldset>
			<legend>{{ lang('short.admin.forms.formViewerEmail') }}</legend>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label class="control-label">{{ lang('short.admin.forms.useEmail') }}</label>
					<div>
						<label class="radio-inline">{{ Form::radio('email_allowed', 1) }} {{ lang('Yes') }}</label>
						<label class="radio-inline">{{ Form::radio('email_allowed', 0) }} {{ lang('No') }}</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.useEmailHelp') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8 col-lg-6">
					<label class="control-label">{{ lang('short.admin.forms.emailAddresses') }}</label>
					{{ Form::textarea('email_addresses', null, ['rows' => 5, 'class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.emailAddressesHelp') }}</p>
				</div>
			</div>
		</fieldset>
	@endif

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('formAction', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}