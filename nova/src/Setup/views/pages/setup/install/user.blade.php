@extends('layouts.setup')

@section('title', 'Create User &amp; Character')

@section('header', 'Create User &amp; Character')

@section('content')
	<h1>Create Your User Account and Character</h1>
	<h3>Tell us a little about yourself and the character you'll play</h3>

	{!! Form::open(['route' => "setup.{$_setupType}.user.store"]) !!}
		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				<h2>User Info</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-5 offset-lg-1">
				<div class="form-group{{ ($errors->has('user.name')) ? ' has-error' : '' }}">
					<label>Name</label>
					<div class="control-wrapper">
						{!! Form::text('user[name]', null, ['class' => 'form-control form-control-lg']) !!}
						{!! $errors->first('user.name', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-5">
				<div class="form-group">
					<label>Nickname</label>
					<div class="control-wrapper">
						{!! Form::text('user[nickname]', null, ['class' => 'form-control form-control-lg']) !!}
						<small class="form-text text-muted">If you specify a nickname, that will be displayed instead of your full name.</small>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-5 offset-lg-1">
				<div class="form-group{{ ($errors->has('user.email')) ? ' has-error' : '' }}">
					<label>Email Address</label>
					<div class="control-wrapper">
						{!! Form::email('user[email]', null, ['class' => 'form-control form-control-lg']) !!}
						{!! $errors->first('user.email', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-5 offset-lg-1">
				<div class="form-group{{ ($errors->has('user.password')) ? ' has-error' : '' }}">
					<label>Password</label>
					<div class="control-wrapper">
						{!! Form::password('user[password]', ['class' => 'form-control form-control-lg']) !!}
						{!! $errors->first('user.password', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-5">
				<div class="form-group{{ ($errors->has('user.confirm_password')) ? ' has-error' : '' }}">
					<label>Confirm Password</label>
					<div class="control-wrapper">
						{!! Form::password('user[confirm_password]', ['class' => 'form-control form-control-lg']) !!}
						{!! $errors->first('user.confirm_password', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				<h2>Character Info</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-5 offset-lg-1">
				<div class="form-group{{ ($errors->has('character.first_name')) ? ' has-error' : '' }}">
					<label>First Name</label>
					<div class="control-wrapper">
						{!! Form::text('character[first_name]', null, ['class' => 'form-control form-control-lg']) !!}
						{!! $errors->first('character.first_name', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-5">
				<div class="form-group">
					<label>Last Name</label>
					{!! Form::text('character[last_name]', null, ['class' => 'form-control form-control-lg']) !!}
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				{!! alert('warning', "More character options, like rank and position, will be available in future preview releases.", "Work In Progress") !!}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				{!! Form::button('Create User &amp; Character', [ 'class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
			</div>
		</div>

		{!! Form::hidden('user[role]', 1) !!}
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Update Settings</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.install.nova') }}" class="btn btn-link btn-lg">Back: Install {{ config('nova.app.name') }}</a></p>
		</div>
	</div>
@stop