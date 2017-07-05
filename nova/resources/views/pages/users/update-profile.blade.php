@extends('layouts.app')

@section('title', _m('user-profile-update'))

@section('content')
	<h1>{{ _m('user-profile-update') }}</h1>

	{!! Form::model($user, ['route' => ['profile.update', $user], 'method' => 'patch']) !!}
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
				<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('email-address') }}</label>
					
					{!! Form::email('email', null, ['class' => 'form-control'.($errors->has('email') ? ' form-control-danger' : '')]) !!}
					
					{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('nickname') }}</label>
					
					{!! Form::text('nickname', null, ['class' => 'form-control']) !!}
					
					<small class="form-text text-muted">{{ _m('user-nickname-explain') }}</small>
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary mr-2">{{ _m('user-profile-update') }}</button>
			<a href="{{ route('profile.show', $user) }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection