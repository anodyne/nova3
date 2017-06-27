@extends('layouts.app')

@section('title', _m('user-update'))

@section('content')
	<h1>{{ _m('user-update') }}</h1>

	{!! Form::model($user, ['route' => ['users.update', $user], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
					<label class="form-control-label sr-only">{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : ''), 'placeholder' => _m('name')]) !!}
					{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
					<label class="form-control-label sr-only">{{ _m('email-address') }}</label>
					{!! Form::email('email', null, ['class' => 'form-control'.($errors->has('email') ? ' form-control-danger' : ''), 'placeholder' => _m('email-address')]) !!}
					{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('nickname') }}</label>
					{!! Form::text('nickname', null, ['class' => 'form-control', 'placeholder' => _m('nickname')]) !!}
					<small class="form-text text-muted">If you set a nickname, it will be displayed throughout Nova instead of your real name.</small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<fieldset>
					<legend>{{ _m('authorize-roles') }}</legend>

					<div class="row">
						@foreach ($roles as $role)
							<div class="col-md-4 mb-3">
								{!! Form::checkbox('roles[]', $role->id, null) !!}
								{{ $role->name }}
							</div>
						@endforeach
					</div>
				</fieldset>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('user-update') }}</button>
			<a href="{{ route('users.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection