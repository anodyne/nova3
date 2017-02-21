@extends('layouts.setup')

@section('title', 'Configure Email')

@section('header', 'Configure Email')

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
		<div class="col-md-6 push-md-6 text-right">
			@if ($_setupType == 'install')
				<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Install {{ config('nova.app.name') }}</a></p>
			@else
				<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Migrate Nova 2</a></p>
			@endif
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-link btn-lg">Back: Restart Email Settings</a></p>
		</div>
	</div>
@stop