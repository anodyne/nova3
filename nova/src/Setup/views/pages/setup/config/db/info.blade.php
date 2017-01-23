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

	<div class="card-deck">
		@if (in_array('mysql', PDO::getAvailableDrivers()))
			<div :class="cardClassName('mysql')">
				<div class="card-block">
					<a role="button" @click="driver = 'mysql'">
						<div class="logo mysql"></div>
					</a>
				</div>
			</div>
		@endif

		@if (in_array('pgsql', PDO::getAvailableDrivers()))
			<div :class="cardClassName('pgsql')">
				<div class="card-block">
					<a role="button" @click="driver = 'pgsql'">
						<div class="logo postgresql"></div>
					</a>
				</div>
			</div>
		@endif

		@if (in_array('sqlite', PDO::getAvailableDrivers()))
			<div :class="cardClassName('sqlite')">
				<div class="card-block">
					<a role="button" @click="driver = 'sqlite'">
						<div class="logo sqlite"></div>
					</a>
				</div>
			</div>
		@endif
	</div>

	<div v-cloak>
		{!! Form::open(['route' => "setup.{$_setupType}.config.db.check"]) !!}
			<div v-show="driver && driver != 'sqlite'">
				<div v-show="driver == 'mysql'">
					<div class="col-md-10 offset-md-1">
						<h2>MySQL</h2>

						<p>MySQL is the database system all previous versions of Nova have used and is one of the most widely available database systems in the world. Most shared hosts have MySQL installed by default so this is most often the best option for running {{ config('nova.app.name') }}. If you have questions about MySQL, get in touch with your web host.</p>
					</div>
				</div>

				<div v-show="driver == 'pgsql'">
					<div class="col-md-10 offset-md-1">
						<h2>PostgreSQL</h2>

						<p>Though often considered to be geared more toward enterprise applications, PostgreSQL is a mature database system in the vein of Oracle. In most cases, PostgresSQL isn't available on shared hosts and will need to be installed separately. If you have questions about PostgresSQL, get in touch with your web host. <strong class="text-warning">This option is currently experimental.</strong></p>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 col-form-label">Host</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_host', 'localhost', ['class' => 'form-control-lg form-control']) !!}
							<p class="help-block">For most web hosts, <code>localhost</code> will be correct. If you aren't sure or the information you received from your web host isn't clear about what the database host name is, contact them for more information.</p>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 col-form-label">Database Name</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_name', false, ['class' => 'form-control-lg form-control']) !!}
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 col-form-label">Table Prefix</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_prefix', 'nova_', ['class' => 'form-control-lg form-control']) !!}
							<p class="help-block">Setting the table prefix will allow you to install {{ config('nova.app.name') }} into a database with other applications.</p>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 col-form-label">Username</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('db_user', false, ['class' => 'form-control-lg form-control']) !!}
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 col-form-label">Password</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::password('db_password', ['class' => 'form-control-lg form-control']) !!}
						</div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-7 offset-md-3">
						{!! Form::button('Create Database Connection', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>

			<div v-show="driver == 'sqlite'">
				<div class="form-group row">
					<div class="col-md-10 offset-md-1">
						<h2>SQLite</h2>

						<p>SQLite is a file-based database that uses a single database file on the server. Because of this, a good rule of thumb is that you should avoid using SQLite in situations where the database will be accessed simultaneously from multiple locations. <strong class="text-danger">SQLite is only advised for development purposes.</strong></p>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 col-form-label">Table Prefix</label>
					<div class="col-md-7">
						{!! Form::text('db_prefix', 'nova_', ['class' => 'form-control-lg form-control']) !!}
						<p class="help-block">Setting the table prefix will allow you to install {{ config('nova.app.name') }} into a database with other applications.</p>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-7 offset-md-3">
						{!! Form::button('Create Database Connection', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 push-sm-6 text-right">
			@if (file_exists(app('path.config').'/database.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-primary btn-lg">Next: Email Settings</a></p>
			@else
				<p><a class="btn btn-link btn-lg disabled">Next: Email Settings</a></p>
			@endif
		</div>
		<div class="col-sm-6 pull-sm-6">
			<p><a href="{{ route('setup.'.$_setupType) }}" class="btn btn-link btn-lg">Back: Fresh Install Info</a></p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		app = {
			data: {
				driver: false
			},

			methods: {
				cardClassName: function (driverType) {
					if (this.driver == driverType) {
						return 'card card-outline-primary'
					}

					return 'card'
				}
			}
		}
	</script>
@stop