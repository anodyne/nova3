{{ Form::model($value, ['url' => 'admin/form/fields/'.$value->field->form->key.'/'.$value->field->id]) }}
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label">{{ lang('Content') }}</label>
			<div class="controls">
				{{ Form::text('content') }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.forms.valuesContent') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label class="control-label">{{ lang('Value') }}</label>
			<div class="controls">
				{{ Form::text('value') }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.forms.valuesValue') }}</p>
		</div>
	</div>

	@if (count($fields) > 1)
		<div class="row">
			<div class="col-lg-6">
				<label class="control-label">{{ lang('Field') }}</label>
				<div class="controls">
					{{ Form::select('field_id', $fields) }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ lang('short.admin.forms.valuesDropdownOnly') }}</p>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="col-lg-3">
			<label class="control-label">{{ lang('Order') }}</label>
			<div class="controls">
				{{ Form::text('order') }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.forms.order') }}</p>
		</div>
	</div>

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'updateValue') }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}