@extends('layouts.app')

@section('title', _m('authorize-role-add'))

@section('content')
	<h1>{{ _m('authorize-role-add') }}</h1>

	{!! Form::open(['route' => 'roles.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-role-name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => _m('authorize-role-name')]) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-role-add') }}</button>
			<a href="{{ route('roles.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection