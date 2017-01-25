@extends('layouts.setup')

@section('title')
	Update Settings
@stop

@section('header')
	Update Settings
@stop

@section('content')
	<h1>Update {{ config('nova.app.name') }} Content &amp; Settings</h1>
	<h3>Take a minute to update some of the basic site content and settings</h3>

	{!! Form::open(['route' => "setup.{$_setupType}.settings.store"]) !!}
		<div class="form-group row{{ ($errors->has('sim_name')) ? ' has-danger' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Sim Name</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('sim_name', null, ['class' => 'form-control form-control-lg', 'v-model' => 'simName']) !!}
					{!! $errors->first('sim_name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row{{ ($errors->has('theme')) ? ' has-danger' : '' }}">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Theme</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::select('theme', $themes, null, ['class' => 'form-control form-control-lg']) !!}
					{!! $errors->first('theme', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-lg-10 offset-lg-1">
				<h2>Email Settings</h2>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Subject Prefix</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('mail_subject_prefix', null, ['class' => 'form-control form-control-lg', 'v-model' => 'mailSubjectPrefix']) !!}
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Default Email Address</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('mail_default_address', null, ['class' => 'form-control form-control-lg']) !!}
					<p class="form-text text-muted">This is the email address all emails sent by {{ config('nova.app.name') }} will come from (unless otherwise specified in code).</p>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Default Name</label>
			<div class="col-md-8 col-lg-7">
				<div class="control-wrapper">
					{!! Form::text('mail_default_name', null, ['class' => 'form-control form-control-lg', 'v-model' => 'mailDefaultName']) !!}
					<p class="form-text text-muted">This is the name all emails sent by {{ config('nova.app.name') }} will come from (unless otherwise specified in code).</p>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-8 offset-md-4 col-lg-9 offset-lg-3">
				{!! Form::button('Update Settings', [ 'class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Go to Your Site</a></p>
		</div>
		<div class="col-md-6 pull-md-6 hidden-sm-down">
			<p>&nbsp;</p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		app = {
			data: {
				simName: ""
			},

			computed: {
				mailSubjectPrefix: function () {
					if (this.simName != "") {
						return '[' + this.simName + ']'
					}
				},

				mailDefaultName: function () {
					if (this.simName != "") {
						return this.simName + ' Admin'
					}
				}
			}
		}
	</script>
@stop