@extends('layouts.setup')

@section('title')
	Configure Database
@stop

@section('header')
	Configure Database
@stop

@section('content')
	<h1>Configure Database</h1>

	<h2>Tell us a little bit about the database Nova is being installed into.</h2>

	{!! Form::open(['route' => 'setup.config.db.check']) !!}
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label">Host</label>
					{!! Form::text('db_host', 'localhost', ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
			<div class="col-md-6 col-md-offset-1">
				<div class="form-group">
					<label class="control-label">Database Host</label>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label">Database Name</label>
					{!! Form::text('db_name', false, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
			<div class="col-md-6 col-md-offset-1">
				<div class="form-group">
					<label class="control-label">Database Name</label>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label">Table Prefix</label>
					{!! Form::text('db_prefix', 'nova_', ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
			<div class="col-md-6 col-md-offset-1">
				<div class="form-group">
					<label class="control-label">Database Table Prefix</label>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label">Username</label>
					{!! Form::text('db_user', false, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
			<div class="col-md-6 col-md-offset-1">
				<div class="form-group">
					<label class="control-label">Database Username</label>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label">Password</label>
					{!! Form::password('db_password', ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
			<div class="col-md-6 col-md-offset-1">
				<div class="form-group">
					<label class="control-label">Database Password</label>
					<p>...</p>
				</div>
			</div>
		</div>
@stop

@section('controls')
		{!! Form::button('Start Install', [ 'class' => 'btn btn-lg btn-primary', 'id' => 'next', 'name' => 'submit', 'type' => 'submit']) !!}
	{!! Form::close() !!}
@stop