@extends('layouts.setup')

@section('title', 'Create User & Character')

@section('header', 'Create User & Character')

@section('content')
	<h1>Create Your User Account and Character</h1>
	<h3>Tell us a little about yourself and the character you'll play</h3>

	@if (session()->has('flash'))
		<div class="alert alert-danger">
			<h4 class="alert-heading">{{ session('flash.title') }}</h4>
			{!! session('flash.message') !!}
		</div>
	@endif

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
									{!! $errors->first('user.name', '<p class="invalid-feedback">:message</p>') !!}
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
									{!! $errors->first('user.email', '<p class="invalid-feedback">:message</p>') !!}
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>How do you prefer to be described?</label>
								<div class="control-wrapper">
									<select name="user[gender]" class="custom-select form-control form-control-lg">
										<option value="neutral">They/them</option>
										<option value="male">He/him</option>
										<option value="female">She/her</option>
									</select>
									<small class="form-text text-muted">Tell us which personal pronouns you prefer to use</small>
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
									{!! $errors->first('user.password', '<p class="invalid-feedback">:message</p>') !!}
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ ($errors->has('user.confirm_password')) ? ' has-danger' : '' }}">
								<label>Confirm Password</label>
								<div class="control-wrapper">
									{!! Form::password('user[confirm_password]', ['class' => 'form-control form-control-lg']) !!}
									{!! $errors->first('user.confirm_password', '<p class="invalid-feedback">:message</p>') !!}
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
									{!! $errors->first('character.name', '<p class="invalid-feedback">:message</p>') !!}
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Position</label>
								<position-picker></position-picker>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Rank</label>
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

				{!! Form::hidden('user[roles][]', 1) !!}
				{!! Form::hidden('user[roles][]', 2) !!}
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('controls')
	@if ($hasUser)
		<a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-primary btn-lg">
			Next: Update Settings
		</a>
	@else
		<a class="btn btn-primary btn-lg disabled">Next: Update Settings</a>
	@endif

	<a href="{{ route('setup.install.nova') }}" class="btn btn-link-secondary btn-lg">
		Back: Install {{ config('nova.app.name') }}
	</a>
@endsection