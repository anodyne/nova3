@extends('layouts.setup')

@section('title', 'Configure Database')

@section('header', 'Configure Database')

@section('content')
	<div class="row">
		<div class="col-lg-10 mx-auto">
			<h1>Database Connection Configured</h1>

			<p>We've verified the connection to the database and created the necessary config file for you. If you need to change your database configuration, you can either edit the <nobr><code>config/database.php</code></nobr> file manually or delete the <nobr><code>config/database.php</code></nobr> file and run this step of the installer again.</p>
		</div>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-primary btn-lg">
		Next: Email Settings
	</a>
	<a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-link-secondary btn-lg">
		Back: Restart Database Connection
	</a>
@endsection