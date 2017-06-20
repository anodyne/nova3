@extends('layouts.app')

@section('title', _m('authorize-permission-add'))

@section('content')
	<h1>{{ _m('authorize-permission-add') }}</h1>

	{!! Form::open(['route' => 'permissions.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-permission-name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => _m('authorize-permission-name')]) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-permission-key') }}</label>
					{!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => _m('authorize-permission-key')]) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-permission-add') }}</button>
			<a href="{{ route('permissions.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection