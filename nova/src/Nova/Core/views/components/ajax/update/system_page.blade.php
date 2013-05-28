{{ Form::model($page, ['url' => 'admin/main/pages']) }}
	<div class="row">
		<div class="col col-lg-6">
			<label class="control-label">{{ ucfirst(lang('name')) }}</label>
			{{ Form::text('name') }}
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-12"><p class="help-block">{{ lang('short.admin.pages.name') }}</p></div>
	</div>

	<div class="row">
		<div class="col col-lg-3">
			<label class="control-label">{{ ucfirst(lang('verb')) }}</label>
			{{ Form::select('verb', ['get' => 'GET', 'post' => 'POST', 'put' => 'PUT', 'delete' => 'DELETE']) }}
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-12">
			<label class="control-label">{{ lang('uri') }}</label>
			{{ Form::text('uri') }}
			<p class="help-block">{{ lang('short.admin.pages.uri') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-12">
			<label class="control-label">{{ ucfirst(lang('resource')) }}</label>
			{{ Form::text('resource') }}
			<p class="help-block">{{ lang('short.admin.pages.resource') }}</p>
		</div>
	</div>

	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}