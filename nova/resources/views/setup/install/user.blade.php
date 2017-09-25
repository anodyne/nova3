@extends('layouts.setup')

@section('title', 'Create User & Character')

@section('header', 'Create User & Character')

@section('content')
	<h1>Create Your User Account and Character</h1>
	<h3>Tell us a little about yourself and the character you'll play</h3>

	<div class="row">
		<div class="col-lg-10 mx-auto">
			{!! Form::open(['route' => "setup.{$_setupType}.user.store"]) !!}
				<fieldset>
					<legend>User Info</legend>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('user.name')) ? ' has-danger' : '' }}">
								<label>Name</label>
								<div class="control-wrapper">
									{!! Form::text('user[name]', null, ['class' => 'form-control form-control-lg']) !!}
									{!! $errors->first('user.name', '<p class="form-control-feedback">:message</p>') !!}
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nickname</label>
								<div class="control-wrapper">
									{!! Form::text('user[nickname]', null, ['class' => 'form-control form-control-lg']) !!}
									<small class="form-text text-muted">If you specify a nickname, it will be displayed throughout {{ config('nova.app.name') }} instead of your full name.</small>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('user.email')) ? ' has-danger' : '' }}">
								<label>Email Address</label>
								<div class="control-wrapper">
									{!! Form::email('user[email]', null, ['class' => 'form-control form-control-lg']) !!}
									{!! $errors->first('user.email', '<p class="form-control-feedback">:message</p>') !!}
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('user.password')) ? ' has-danger' : '' }}">
								<label>Password</label>
								<div class="control-wrapper">
									{!! Form::password('user[password]', ['class' => 'form-control form-control-lg']) !!}
									{!! $errors->first('user.password', '<p class="form-control-feedback">:message</p>') !!}
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('user.confirm_password')) ? ' has-danger' : '' }}">
								<label>Confirm Password</label>
								<div class="control-wrapper">
									{!! Form::password('user[confirm_password]', ['class' => 'form-control form-control-lg']) !!}
									{!! $errors->first('user.confirm_password', '<p class="form-control-feedback">:message</p>') !!}
								</div>
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend>Character Info</legend>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('character.first_name')) ? ' has-danger' : '' }}">
								<label>Name</label>
								<div class="control-wrapper">
									{!! Form::text('character[name]', null, ['class' => 'form-control form-control-lg']) !!}
									{!! $errors->first('character.name', '<p class="form-control-feedback">:message</p>') !!}
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Position</label>
								<position-picker></position-picker>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label class="form-control-label">Rank</label>
								<div>
									<rank-picker></rank-picker>
								</div>
							</div>
						</div>
					</div>
				</fieldset>

				<div class="form-group">
					{!! Form::button('Create User & Character', [ 'class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
				</div>

				{!! Form::hidden('user[role]', 1) !!}
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('controls')
	<a class="btn btn-primary btn-lg disabled">Next: Update Settings</a>
	<a href="{{ route('setup.install.nova') }}" class="btn btn-link-secondary btn-lg">
		Back: Install {{ config('nova.app.name') }}
	</a>
@endsection