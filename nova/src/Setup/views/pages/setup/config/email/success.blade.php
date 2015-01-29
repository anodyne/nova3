@extends('layouts.setup')

@section('title')
	Configure Email
@stop

@section('header')
	Configure Email
@stop

@section('content')
	<h1>Email Configured</h1>

	<p>We've created the necessary config file for you. If you need to change your email configuration, you can either edit the <code>config/mail.php</code> file manually or delete the <code>config/mail.php</code> file and run this step of the installer again.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-link">Back: Restart Email Settings</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary">Next: Install {{ config('nova.app.name') }}</a></p>
		</div>
	</div>
@stop