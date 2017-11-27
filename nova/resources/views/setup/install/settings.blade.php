@extends('layouts.setup')

@section('title', 'Update Settings')

@section('header', 'Update Settings')

@section('content')
	<h1>Update {{ config('nova.app.name') }} Content &amp; Settings</h1>
	<h3>Take a minute to update some of the basic site content and settings</h3>

	<div class="row">
		<div class="col-lg-10 mx-auto">
			{!! Form::open(['route' => "setup.{$_setupType}.settings.store"]) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group{{ ($errors->has('sim_name')) ? ' has-danger' : '' }}">
							<label>Sim Name</label>
							<div class="control-wrapper">
								{!! Form::text('sim_name', null, ['class' => 'form-control form-control-lg', 'v-model' => 'simName']) !!}
								{!! $errors->first('sim_name', '<p class="form-control-feedback">:message</p>') !!}
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group{{ ($errors->has('theme')) ? ' has-danger' : '' }}">
							<label>Theme</label>
							<div class="control-wrapper">
								{!! Form::select('theme', $themes, null, ['class' => 'form-control form-control-lg']) !!}
								{!! $errors->first('theme', '<p class="form-control-feedback">:message</p>') !!}
							</div>
						</div>
					</div>
				</div>

				<fieldset>
					<legend>Email Settings</legend>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Subject Prefix</label>
								<div class="control-wrapper">
									{!! Form::text('mail_subject_prefix', null, ['class' => 'form-control form-control-lg', 'v-model' => 'mailSubjectPrefix']) !!}
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Default Email Address</label>
								<div class="control-wrapper">
									{!! Form::text('mail_default_address', null, ['class' => 'form-control form-control-lg']) !!}
									<small class="form-text text-muted">This is the email address all emails sent by {{ config('nova.app.name') }} will come from (unless otherwise specified in code).</small>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Default Name</label>
								<div class="control-wrapper">
									{!! Form::text('mail_default_name', null, ['class' => 'form-control form-control-lg', 'v-model' => 'mailDefaultName']) !!}
									<small class="form-text text-muted">This is the name all emails sent by {{ config('nova.app.name') }} will come from (unless otherwise specified in code).</small>
								</div>
							</div>
						</div>
					</div>
				</fieldset>

				<div class="form-group">
					{!! Form::button('Update Settings', [ 'class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('controls')
	<a class="btn btn-primary btn-lg disabled">Next: Go to Your Site</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				simName: ''
			},

			computed: {
				mailSubjectPrefix () {
					if (this.simName != "") {
						return '[' + this.simName + ']';
					}
				},

				mailDefaultName () {
					if (this.simName != "") {
						return this.simName + ' Admin';
					}
				}
			}
		};
	</script>
@endsection