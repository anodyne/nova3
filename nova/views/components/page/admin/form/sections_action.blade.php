<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($section, ['url' => 'admin/form/sections/'.$formKey]) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group">
				<label class="control-label">{{ lang('Name') }}</label>
				{{ Form::text('name', null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 col-lg-2">
			<label class="control-label">{{ lang('Order') }}</label>
			{{ Form::text('order', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.forms.order') }}</p>
		</div>
	</div>

	@if (count($tabs) > 0)
		<div class="row">
			<div class="col-sm-6 col-lg-4">
				<div class="form-group">
					<label class="control-label">{{ lang('Tab') }}</label>
					{{ Form::select('tab_id', $tabs, null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>
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