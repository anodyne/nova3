@extends('layouts.setup')

@section('title')
	Create User &amp; Character
@stop

@section('header')
	Create User &amp; Character
@stop

@section('content')
	<h1>Create Your User Account and Character</h1>
	<h3>Tell us a little about yourself and the character you'll play</h3>

	{!! Form::open(['route' => "setup.{$_setupType}.user.store"]) !!}
		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				<h2>User Info</h2>
			</div>
		</div>

		<div class="form-group row{{ ($errors->has('user.name')) ? ' has-error' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Name</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('user[name]', null, ['class' => 'form-control form-control-lg']) !!}
					{!! $errors->first('user.name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Nickname</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('user[nickname]', null, ['class' => 'form-control form-control-lg']) !!}
					<small class="form-text text-muted">If you specify a nickname, that will be displayed throughout {{ config('nova.app.name') }} instead of your real name.</small>
				</div>
			</div>
		</div>

		<div class="form-group row{{ ($errors->has('user.email')) ? ' has-error' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Email Address</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::email('user[email]', null, ['class' => 'form-control form-control-lg']) !!}
					{!! $errors->first('user.email', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row{{ ($errors->has('user.password')) ? ' has-error' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Password</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::password('user[password]', ['class' => 'form-control form-control-lg']) !!}
					{!! $errors->first('user.password', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row{{ ($errors->has('user.confirm_password')) ? ' has-error' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Confirm Password</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::password('user[confirm_password]', ['class' => 'form-control form-control-lg']) !!}
					{!! $errors->first('user.confirm_password', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				<h2>Character Info</h2>
			</div>
		</div>

		<div class="form-group row{{ ($errors->has('character.first_name')) ? ' has-error' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">First Name</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('character[first_name]', null, ['class' => 'form-control form-control-lg']) !!}
					{!! $errors->first('character.first_name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Last Name</label>
			<div class="col-md-8 col-lg-7">
				{!! Form::text('character[last_name]', null, ['class' => 'form-control form-control-lg']) !!}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-8 offset-md-4 col-lg-9 offset-lg-3">
				{!! alert('warning', "More character options, like rank and position, will be available in future preview releases.", "Work In Progress") !!}
			</div>
		</div>

		{!! Form::hidden('user[role]', 1) !!}

		<div class="form-group row">
			<div class="col-md-8 offset-md-4 col-lg-9 offset-lg-3">
				{!! Form::button('Create User &amp; Character', [ 'class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
			</div>
		</div>
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