@extends('layouts.setup')

@section('title', 'Nova 2 Connection')

@section('header', 'Nova 2 Connection')

@section('content')
	<h1>Configure Nova 2 Connection</h1>
	<h3>Tell us a little bit about where your Nova 2 data lives</h3>

	<div v-cloak>
		{!! Form::open(['route' => "setup.{$_setupType}.config.nova2.check"]) !!}
			<div class="row">
				<div class="col-md-9 col-lg-8 offset-lg-1">
					<div class="form-group">
						<label>Host</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_host', 'localhost', ['class' => 'form-control form-control-lg']) !!}
							<small class="form-text text-muted">For most web hosts, <code>localhost</code> will be correct. If you aren't sure, refer to the information you received from your web host or contact them directly.</small>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 col-lg-5 offset-lg-1">
					<div class="form-group">
						<label>Database Name</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_name', false, ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5">
					<div class="form-group">
						<label>Table Prefix</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_prefix', 'nova_', ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 col-lg-5 offset-lg-1">
					<div class="form-group">
						<label>Username</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_user', false, ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5">
					<div class="form-group">
						<label>Password</label>
						<div class="control-wrapper">
							{!! Form::password('nova2_db_password', ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-lg-10 offset-lg-1">
					{!! Form::button('Check Nova 2 Connection', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			@if (file_exists(app('path.config').'/mail.php'))
				<p><a href="{{ route('setup.'.$_setupType) }}" class="btn btn-primary btn-lg">Next: Database Connection</a></p>
			@else
				<p><a class="btn btn-link btn-lg disabled">Next: Database Connection</a></p>
			@endif
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.'.$_setupType) }}" class="btn btn-link btn-lg">Cancel</a></p>
		</div>
	</div>
@stop

@section('js')
	<script>
		app = {
			data: {
				'driver': false
			},

			computed: {
				driverClassName: function () {
					if (this.driver == 'smtp') {
						return 'form-group has-success'
					}

					if (this.driver == 'mail') {
						return 'form-group has-warning'
					}

					if (this.driver == 'log') {
						return 'form-group has-danger'
					}

					return 'form-group'
				}
			}
		}
	</script>
@stop