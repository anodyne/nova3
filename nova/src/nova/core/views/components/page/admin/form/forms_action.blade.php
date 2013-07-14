<div class="btn-group">
	<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
</div>

{{ Form::model($form, ['url' => 'admin/form']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">{{ Form::text('name') }}</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ langConcat('Form Key') }}</label>
			{{ Form::text('key') }}
		</div>
	</div>	
	<div class="row">
		<div class="col-sm-8 col-lg-6 has-error">
			<p class="help-block">{{ lang('short.admin.forms.changeFormKey') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ lang('Orientation') }}</label>
				<div class="controls">{{ Form::select('orientation', ['vertical' => lang('Vertical'), 'horizontal' => lang('Horizontal')]) }}</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ lang('Status') }}</label>
				<div class="controls">{{ Form::select('status', [Status::ACTIVE => lang('Active'), Status::INACTIVE => lang('Inactive')]) }}</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ ucwords(lang('Data_model')) }}</label>
			<div class="controls">{{ Form::text('data_model') }}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-lg-6">
			<p class="help-block">{{ lang('short.admin.forms.dataModel') }}</p>
		</div>
	</div>

	@if ($action == 'create' or ($action == 'update' and (bool) $form->protected === false))
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
				<label class="control-label">{{ lang('short.admin.forms.formViewerMessage') }}</label>
				<div class="controls">
					{{ Form::textarea('form_viewer_message', null, ['rows' => 3]) }}
				</div>
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
					<div class="controls">
						{{ Form::select('form_viewer_display', $formFields) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.formViewerDisplayHelp') }}</p>
				</div>
			</div>
		@endif

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
				<div class="control-group">
					<label class="control-label">{{ lang('short.admin.forms.emailAddresses') }}</label>
					<div class="controls">
						{{ Form::textarea('email_addresses', null, ['rows' => 2]) }}
					</div>
				</div>
			</div>
		</div>
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}