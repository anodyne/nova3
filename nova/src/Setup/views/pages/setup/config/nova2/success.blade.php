@extends('layouts.setup')

@section('title', 'Nova 2 Connection')

@section('header', 'Nova 2 Connection')

@section('content')
	<h1>Nova 2 Connection Configured</h1>

	<p>We've created the necessary config file for you. If you need to change your email configuration, you can either edit the <nobr><code>config/mail.php</code></nobr> file manually or delete the <nobr><code>config/mail.php</code></nobr> file and run this step of the installer again.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Install {{ config('nova.app.name') }}</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-link btn-lg">Back: Restart Email Settings</a></p>
		</div>
	</div>
@stop