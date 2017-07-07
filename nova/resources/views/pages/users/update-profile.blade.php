@extends('layouts.app')

@section('title', _m('user-profile-update'))

@section('content')
	<h1>{{ _m('user-profile-update') }}</h1>

	<mobile>
		<p><a href="#" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#changePassword">{{ _m('user-profile-password-change') }}</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#changePassword">{{ _m('user-profile-password-change') }}</a>
			</div>
		</div>
	</desktop>

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

	<div id="changePassword" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ _m('user-profile-password-change') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="{{ _m('close') }}">
						<span aria-hidden="true">{!! icon('close') !!}</span>
					</button>
				</div>

				{!! Form::open(['route' => ['profile.password', $_user], 'method' => 'patch']) !!}
					<div class="modal-body">
						<div class="form-group">
							<label class="form-control-label">Current Password</label>
							{!! Form::password('password_current', ['class' => 'form-control']) !!}
						</div>

						<div class="form-group">
							<label class="form-control-label">New Password</label>
							{!! Form::password('password_new', ['class' => 'form-control']) !!}
						</div>

						<div class="form-group">
							<label class="form-control-label">Confirm New Password</label>
							{!! Form::password('password_new_confirmation', ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">{{ _m('Save') }}</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _m('close') }}</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection