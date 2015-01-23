@extends('layouts.setup')

@section('title')
	Database Connection
@stop

@section('header')
	Database Connection
@stop

@section('content')
	<h1>Configure Your Database Connection</h1>
	<h2>Tell us a little bit about the database {{ config('nova.app.name') }} is being installed into</h2>

	{!! Form::open(['route' => "setup.{$_setupType}.config.db.check", 'class' => 'form-horizontal']) !!}
		<div class="form-group">
			<label class="col-md-3 control-label">Host</label>
			<div class="col-md-7">
				{!! Form::text('db_host', 'localhost', ['class' => 'input-lg form-control']) !!}
				<p class="help-block">For most web hosts, <em>localhost</em> will be correct. If you aren't sure or the information you received from your web host isn't clear about what the database host name is, contact them for more information.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Database Name</label>
			<div class="col-md-7">
				{!! Form::text('db_name', false, ['class' => 'input-lg form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Table Prefix</label>
			<div class="col-md-7">
				{!! Form::text('db_prefix', 'nova_', ['class' => 'input-lg form-control']) !!}
				<p class="help-block">Setting the table prefix will allow you to install {{ config('nova.app.name') }} into a database with other applications.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Username</label>
			<div class="col-md-7">
				{!! Form::text('db_user', false, ['class' => 'input-lg form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Password</label>
			<div class="col-md-7">
				{!! Form::text('db_password', false, ['class' => 'input-lg form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				{!! Form::button('Test Database Connection', [ 'class' => 'btn btn-primary btn-lg', 'id' => 'next', 'name' => 'submit', 'type' => 'submit']) !!}
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.'.$_setupType) }}" class="btn btn-link">Back</a></p>
		</div>
		<div class="col-md-6 text-right">
			@if (file_exists(app('path.config').'/database.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-primary">Next: Email Settings</a></p>
			@else
				<p><a class="btn btn-link disabled">Next: Email Settings</a></p>
			@endif
		</div>
	</div>
@stop