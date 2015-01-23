@extends('layouts.setup')

@section('title')
	Configure Database
@stop

@section('header')
	Configure Database
@stop

@section('content')
	<h1>Database Connection Configured</h1>

	<p>We've verified the connection to the database and created the necessary config file for you. If you need to change your database configuration, you can either edit the <code>config/database.php</code> file manually or delete the <code>config/database.php</code> file and run this step of the installer again.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-link">Back: Database Connection</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-primary">Next: Email Settings</a></p>
		</div>
	</div>
@stop