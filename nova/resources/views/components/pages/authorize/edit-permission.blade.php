<h1>{{ _m('authorize-permissions-update') }}</h1>

{!! Form::model($permission, ['route' => ['permissions.update', $permission], 'method' => 'patch']) !!}
	<div class="row">
		<div class="col md:col-4">
			<text-input label="{{ _m('name') }}" name="name" value="{{ $permission->name }}" error="{{ $errors->first('name') }}"></text-input>
		</div>
	</div>

	<div class="row">
		<div class="col md:col-4">
			<text-input label="{{ _m('key') }}" name="key" value="{{ $permission->key }}" error="{{ $errors->first('key') }}"></text-input>
		</div>
	</div>

	<div class="submit-controls">
		<button type="submit" class="button is-primary">{{ _m('authorize-permissions-update') }}</button>
		<a href="{{ route('permissions.index') }}" class="button is-secondary">{{ _m('cancel') }}</a>
	</div>
{!! Form::close() !!}