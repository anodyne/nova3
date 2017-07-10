@extends('layouts.app')

@section('title', _m('authorize-permission-add'))

@section('content')
	<h1>{{ _m('authorize-permission-add') }}</h1>

	{!! Form::open(['route' => 'permissions.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : '')]) !!}
					{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('key') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('authorize-permission-key') }}</label>
					{!! Form::text('key', null, ['class' => 'form-control'.($errors->has('key') ? ' form-control-danger' : '')]) !!}
					{!! $errors->first('key', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-permission-add') }}</button>
			<a href="{{ route('permissions.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection