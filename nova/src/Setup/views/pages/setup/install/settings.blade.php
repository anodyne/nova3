@extends('layouts.setup')

@section('title')
	Update Settings
@stop

@section('header')
	Update Settings
@stop

@section('content')
	<h1>Update {{ config('nova.app.name') }} Settings</h1>
	<h2>Take a minute to update some of the basic system settings</h2>

	{!! Form::open(['route' => "setup.{$_setupType}.settings.store", 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('sim_name')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Sim Name</label>
			<div class="col-md-7">
				<div class="control-wrapper">
					{!! Form::text('sim_name', null, ['class' => 'input-lg form-control']) !!}
					{!! $errors->first('sim_name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				{!! Form::button('Update Settings', [ 'class' => 'btn btn-primary', 'type' => 'submit']) !!}
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p>&nbsp;</p>
		</div>
		<div class="col-md-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Go to Your Site</a></p>
		</div>
	</div>
@stop