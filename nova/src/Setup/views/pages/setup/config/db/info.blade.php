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
			<label class="col-md-3 control-label">Driver</label>
			<div class="col-md-7">
				@if (in_array('mysql', PDO::getAvailableDrivers()))
					<div class="radio">
						<label>
							{!! Form::radio('db_driver', 'mysql', false) !!} <div class="logo mysql"></div>
						</label>
					</div>
				@endif

				@if (in_array('pgsql', PDO::getAvailableDrivers()))
					<div class="radio">
						<label>
							{!! Form::radio('db_driver', 'pgsql', false) !!} <div class="logo postgresql"></div>
						</label>
					</div>
				@endif

				@if (in_array('sqlite', PDO::getAvailableDrivers()))
					<div class="radio">
						<label>
							{!! Form::radio('db_driver', 'sqlite', false) !!} <div class="logo sqlite"></div>
						</label>
					</div>
				@endif
			</div>
		</div>

		<div id="not-sqlite" class="hide">
			<div class="form-group hide" id="not-sqlite-mysql">
				<div class="col-md-8 col-md-offset-3">
					<h3>MySQL</h3>

					<p>MySQL is the database driver that all previous versions of Nova have used and is one of the most widely available database systems in the world. Most shared hosts have MySQL installed by default so this is most often the best option for running {{ config('nova.app.name') }}. If you have questions about MySQL, get in touch with your web host.</p>
				</div>
			</div>

			<div class="form-group hide" id="not-sqlite-pgsql">
				<div class="col-md-8 col-md-offset-3">
					<h3>PostgreSQL</h3>

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

		<div id="sqlite" class="hide">
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<h3>SQLite</h3>

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
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.'.$_setupType) }}" class="btn btn-link btn-lg">Back: Fresh Install Info</a></p>
		</div>
		<div class="col-md-6 text-right">
			@if (file_exists(app('path.config').'/database.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-primary btn-lg">Next: Email Settings</a></p>
			@else
				<p><a class="btn btn-link btn-lg disabled">Next: Email Settings</a></p>
			@endif
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$(function()
		{
			if ($('[name="db_driver"]').is(':checked'))
			{
				doShowHide($('[name="db_driver"]:checked').val());
			}
		});

		$('[name="db_driver"]').on('change', function(e)
		{
			doShowHide($('[name="db_driver"]:checked').val());
		});

		function doShowHide(selected)
		{
			if (selected == "mysql")
			{
				$('#not-sqlite').removeClass('hide');
				$('#not-sqlite-mysql').removeClass('hide');
				$('#not-sqlite-pgsql').addClass('hide');
				$('#sqlite').addClass('hide');
			}

			if (selected == "pgsql")
			{
				$('#not-sqlite').removeClass('hide');
				$('#not-sqlite-pgsql').removeClass('hide');
				$('#not-sqlite-mysql').addClass('hide');
				$('#sqlite').addClass('hide');
			}

			if (selected == "sqlite")
			{
				$('#sqlite').removeClass('hide');
				$('#not-sqlite').addClass('hide');
				$('#not-sqlite-pgsql').addClass('hide');
				$('#not-sqlite-mysql').addClass('hide');
			}
		}
	</script>
@stop