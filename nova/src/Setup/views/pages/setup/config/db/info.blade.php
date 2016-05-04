@extends('layouts.setup')

@section('title')
	Database Connection
@stop

@section('header')
	Database Connection
@stop

@section('content')
	<h1>Configure Your Database Connection</h1>
	<h3>Tell us a little bit about the database {{ config('nova.app.name') }} is being installed into</h3>

	<div v-cloak>
		{!! Form::open(['route' => "setup.{$_setupType}.config.db.check", 'class' => 'form-horizontal']) !!}
			<div class="form-group">
				<label class="col-md-3 control-label">Driver</label>
				<div class="col-md-7">
					@if (in_array('mysql', PDO::getAvailableDrivers()))
						<div class="radio">
							<label>
								{!! Form::radio('db_driver', 'mysql', false, ['v-model' => 'driver']) !!} <div class="logo mysql"></div>
							</label>
						</div>
					@endif

					@if (in_array('pgsql', PDO::getAvailableDrivers()))
						<div class="radio">
							<label>
								{!! Form::radio('db_driver', 'pgsql', false, ['v-model' => 'driver']) !!} <div class="logo postgresql"></div>
							</label>
						</div>
					@endif

					@if (in_array('sqlite', PDO::getAvailableDrivers()))
						<div class="radio">
							<label>
								{!! Form::radio('db_driver', 'sqlite', false, ['v-model' => 'driver']) !!} <div class="logo sqlite"></div>
							</label>
						</div>
					@endif
				</div>
			</div>

			<div v-show="driver && driver != 'sqlite'">
				<div v-show="driver == 'mysql'">
					<div class="col-md-8 col-md-offset-3">
						<h2>MySQL</h2>

						<p>MySQL is the database driver that all previous versions of Nova have used and is one of the most widely available database systems in the world. Most shared hosts have MySQL installed by default so this is most often the best option for running {{ config('nova.app.name') }}. If you have questions about MySQL, get in touch with your web host.</p>
					</div>
				</div>

				<div v-show="driver == 'pgsql'">
					<div class="col-md-8 col-md-offset-3">
						<h2>PostgreSQL</h2>

						<p>Though often considered to be geared more toward enterprise applications, PostgreSQL is a mature database system in the vein of Oracle. In most cases, PostgresSQL isn't available on shared hosts and will need to be installed separately. If you have questions about PostgresSQL, get in touch with your web host. <strong class="text-warning">This option is currently experimental.</strong></p>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Host</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_host', 'localhost', ['class' => 'input-lg form-control']) !!}
							<p class="help-block">For most web hosts, <code>localhost</code> will be correct. If you aren't sure or the information you received from your web host isn't clear about what the database host name is, contact them for more information.</p>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Database Name</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_name', false, ['class' => 'input-lg form-control']) !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Table Prefix</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_prefix', 'nova_', ['class' => 'input-lg form-control']) !!}
							<p class="help-block">Setting the table prefix will allow you to install {{ config('nova.app.name') }} into a database with other applications.</p>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Username</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_user', false, ['class' => 'input-lg form-control']) !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Password</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::password('db_password', ['class' => 'input-lg form-control']) !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-7 col-md-offset-3">
						{!! Form::button('Create Database Connection', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>

			<div v-show="driver == 'sqlite'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>SQLite</h2>

						<p>SQLite is a file-based database that uses a single database file on the server. Because of this, a good rule of thumb is that you should avoid using SQLite in situations where the database will be accessed simultaneously from multiple locations. Because of this, <strong class="text-danger">SQLite is only advised for development purposes.</strong></p>
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
					<div class="col-md-7 col-md-offset-3">
						{!! Form::button('Create Database Connection', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 col-sm-push-6 text-right">
			@if (file_exists(app('path.config').'/database.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-primary btn-lg">Next: Email Settings</a></p>
			@else
				<p><a class="btn btn-link btn-lg disabled">Next: Email Settings</a></p>
			@endif
		</div>
		<div class="col-sm-6 col-sm-pull-6">
			<p><a href="{{ route('setup.'.$_setupType) }}" class="btn btn-link btn-lg">Back: Fresh Install Info</a></p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		var vm = new Vue({
			el: "#app",

			data: {
				driver: false
			}
		})
	</script>
@stop