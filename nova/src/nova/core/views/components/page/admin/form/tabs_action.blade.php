<div class="visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
		</div>
	</div>
</div>
<div class="hidden-lg">
	<div class="row">
		<div class="col-4">
			<p><a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['back'] }}</a></p>
		</div>
	</div>
</div>

{{ Form::model($tab, ['url' => 'admin/form/tabs/'.$formKey]) }}
	<div class="row">
		<div class="col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">
					{{ Form::text('name') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-2">
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

	<div class="row">
		<div class="col-lg-2">
			<label class="control-label">{{ langConcat('Link id') }}</label>
			<div class="controls">
				{{ Form::text('link_id') }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block">{{ lang('short.admin.forms.tabLinkId') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-2">
			<div class="control-group">
				<label class="control-label">{{ lang('Display') }}</label>
				<div class="controls">
					<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
					<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('action', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}