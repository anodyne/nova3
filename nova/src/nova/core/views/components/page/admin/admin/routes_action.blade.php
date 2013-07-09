<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/routes') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($route, ['url' => 'admin/routes']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ lang('Name') }}</label>
			<div class="controls">{{ Form::text('name') }}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.pages.name') }}</p></div>
	</div>

	<div class="row">
		<div class="col-6 col-sm-4 col-lg-2">
			<div class="control-group">
				<label class="control-label">{{ lang('Verb') }}</label>
				<div class="controls">
					{{ Form::select('verb', ['get' => 'GET', 'post' => 'POST', 'put' => 'PUT', 'delete' => 'DELETE']) }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ lang('uri') }}</label>
			<div class="controls">{{ Form::text('uri') }}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.pages.uri') }}</p></div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<label class="control-label">{{ lang('Resource') }}</label>
			<div class="controls">{{ Form::text('resource') }}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.pages.resource') }}</p></div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label class="control-label">{{ lang('Conditions') }}</label>
			<div class="controls">{{ Form::textarea('conditions', null, ['rows' => 3]) }}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.pages.conditions') }}</p></div>
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