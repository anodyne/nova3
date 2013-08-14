<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/routes') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($route, ['url' => 'admin/routes']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label>{{ lang('Name') }}</label>
			{{ Form::text('name', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.routes.name') }}</p></div>
	</div>

	<div class="row">
		<div class="col-xs-6 col-sm-4 col-lg-2">
			<div class="form-group">
				<label>{{ lang('Verb') }}</label>
				{{ Form::select('verb', ['get' => 'GET', 'post' => 'POST', 'put' => 'PUT', 'delete' => 'DELETE'], null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label>{{ lang('uri') }}</label>
			{{ Form::text('uri', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.routes.uri') }}</p></div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<label>{{ lang('Resource') }}</label>
			{{ Form::text('resource', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.routes.resource') }}</p></div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label>{{ lang('Conditions') }}</label>
			{{ Form::textarea('conditions', null, ['rows' => 3, 'class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><p class="help-block">{{ lang('short.admin.routes.conditions') }}</p></div>
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