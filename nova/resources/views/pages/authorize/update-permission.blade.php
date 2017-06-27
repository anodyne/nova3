@extends('layouts.app')

@section('title', _m('authorize-permission-update'))

@section('content')
	<h1>{{ _m('authorize-permission-update') }}</h1>

	{!! Form::model($permission, ['route' => ['permissions.update', $permission], 'method' => 'patch']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-permission-name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-permission-key') }}</label>
					{!! Form::text('key', null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-permission-update') }}</button>
			<a href="{{ route('permissions.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection