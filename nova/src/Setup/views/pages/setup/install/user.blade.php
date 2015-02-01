@extends('layouts.setup')

@section('title')
	Create User &amp; Character
@stop

@section('header')
	Create User &amp; Character
@stop

@section('content')
	<h1>Create Your User Account and Character</h1>
	<h2>Tell us a little about yourself and the character you'll play</h2>

	{!! Form::open(['route' => "setup.{$_setupType}.user.store", 'class' => 'form-horizontal']) !!}
		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				<h3>User Info</h3>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('user.name')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Name</label>
			<div class="col-md-7">
				{!! Form::text('user[name]', null, ['class' => 'input-lg form-control']) !!}
				{!! $errors->first('user.name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('user.email')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Email Address</label>
			<div class="col-md-7">
				{!! Form::email('user[email]', null, ['class' => 'input-lg form-control']) !!}
				{!! $errors->first('user.email', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('user.password')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Password</label>
			<div class="col-md-7">
				{!! Form::password('user[password]', ['class' => 'input-lg form-control']) !!}
				{!! $errors->first('user.password', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('user.confirm_password')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Confirm Password</label>
			<div class="col-md-7">
				{!! Form::password('user[confirm_password]', ['class' => 'input-lg form-control']) !!}
				{!! $errors->first('user.confirm_password', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				<h3>Character Info</h3>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('character.first_name')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">First Name</label>
			<div class="col-md-7">
				{!! Form::text('character[first_name]', null, ['class' => 'input-lg form-control']) !!}
				{!! $errors->first('character.first_name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Last Name</label>
			<div class="col-md-7">
				{!! Form::text('character[last_name]', null, ['class' => 'input-lg form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				{!! alert('warning', "More character options, like rank and position, will be available in future preview releases.", "Work In Progress") !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				{!! Form::button('Create User &amp; Character', [ 'class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.install.nova') }}" class="btn btn-link">Back: Install {{ config('nova.app.name') }}</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p><a class="btn btn-link disabled">Next: Finalize</a></p>
		</div>
	</div>
@stop