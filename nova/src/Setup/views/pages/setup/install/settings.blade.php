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

		<div class="form-group{{ ($errors->has('theme')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Theme</label>
			<div class="col-md-4">
				<div class="control-wrapper">
					{!! Form::select('theme', $themes, null, ['class' => 'input-lg form-control']) !!}
					{!! $errors->first('theme', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				<h3>Email Settings</h3>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Subject Prefix</label>
			<div class="col-md-7">
				<div class="control-wrapper">
					{!! Form::text('mail_subject_prefix', null, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Default Email Address</label>
			<div class="col-md-7">
				<div class="control-wrapper">
					{!! Form::text('mail_default_address', null, ['class' => 'input-lg form-control']) !!}
					<p class="help-block">This is the email address all emails sent by {{ config('nova.app.name') }} will come from (unless otherwise specified in code).</p>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Default Name</label>
			<div class="col-md-7">
				<div class="control-wrapper">
					{!! Form::text('mail_default_name', null, ['class' => 'input-lg form-control']) !!}
					<p class="help-block">This is the name all emails sent by {{ config('nova.app.name') }} will come from (unless otherwise specified in code).</p>
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
		<div class="col-sm-6 col-sm-push-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Go to Your Site</a></p>
		</div>
		<div class="col-sm-6 col-sm-pull-6 hidden-xs">
			<p>&nbsp;</p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$('[name="sim_name"]').on('change', function(e)
		{
			$('[name="mail_subject_prefix"]').val("[" + $(this).val() + "]");
			$('[name="mail_default_name"]').val($(this).val());
		});
	</script>
@stop