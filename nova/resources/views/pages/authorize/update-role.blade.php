@extends('layouts.app')

@section('title', _m('authorize-role-update'))

@section('content')
	<h1>{{ _m('authorize-role-update') }}</h1>

	{!! Form::model($role, ['route' => ['roles.update', $role], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-role-name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-role-update') }}</button>
			<a href="{{ route('roles.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection