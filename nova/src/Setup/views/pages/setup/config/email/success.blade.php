@extends('layouts.setup')

@section('title')
	Configure Email
@stop

@section('header')
	Configure Email
@stop

@section('content')
	<h1>Email Configured</h1>

	@if (config('mail.driver') == 'sparkpost' or config('mail.driver') == 'mailgun')
		<p>We've created the necessary config files for you.</p>

		<p>If you need to change your email configuration, you can either edit the <nobr><code>config/mail.php</code></nobr> file manually or delete the <nobr><code>config/mail.php</code></nobr> file and run this step of the installer again.</p>

		<p>If you need to change how {{ config('nova.app.name') }} connects to the email API, you can either edit the <nobr><code>config/services.php</code></nobr> file manually or delete the <nobr><code>config/mail.php</code></nobr> and <nobr><code>config/services.php</code></nobr> files and run this step of the installer again.</p>
	@else
		<p>We've created the necessary config file for you. If you need to change your email configuration, you can either edit the <nobr><code>config/mail.php</code></nobr> file manually or delete the <nobr><code>config/mail.php</code></nobr> file and run this step of the installer again.</p>
	@endif
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 col-sm-push-6 text-right">
			<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Install {{ config('nova.app.name') }}</a></p>
		</div>
		<div class="col-sm-6 col-sm-pull-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-link btn-lg">Back: Restart Email Settings</a></p>
		</div>
	</div>
@stop