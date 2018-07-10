<h1>{{ _m('authorize-permissions-add') }}</h1>

<form action="{{ route('permissions.store') }}" method="post">
	@csrf

	<div class="row">
		<div class="col md:col-4">
			<text-input label="{{ _m('name') }}" name="name" error="{{ $errors->first('name') }}"></text-input>
		</div>
	</div>

	<div class="row">
		<div class="col md:col-4">
			<text-input label="{{ _m('key') }}" name="key" error="{{ $errors->first('key') }}"></text-input>
		</div>
	</div>

	<div class="submit-controls">
		<button type="submit" class="button is-primary">{{ _m('authorize-permissions-add') }}</button>
		<a href="{{ route('permissions.index') }}" class="button is-secondary">{{ _m('cancel') }}</a>
	</div>
</form>
