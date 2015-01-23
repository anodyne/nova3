@extends('layouts.setup')

@section('title')
	Configure Database
@stop

@section('header')
	Configure Database
@stop

@section('content')
	<h1>Configure Your Database</h1>
	<h2>Tell us a little bit about the database {{ config('nova.app.name') }} is being installed into</h2>

	{!! Form::open(['route' => 'setup.install.config.db.check', 'class' => 'form-horizontal']) !!}
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
				{!! Form::button('Test Database', [ 'class' => 'btn btn-primary btn-lg', 'id' => 'next', 'name' => 'submit', 'type' => 'submit']) !!}
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.install') }}" class="btn btn-link">Back</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p><a class="btn btn-link disabled">Next: Email</a></p>
		</div>
	</div>
@stop