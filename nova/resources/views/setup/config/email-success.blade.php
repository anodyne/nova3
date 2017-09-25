@extends('layouts.setup')

@section('title', 'Configure Email')

@section('header', 'Configure Email')

@section('content')
	<div class="row">
		<div class="col-lg-10 mx-auto">
			<h1>Email Configured</h1>

			<p>We've created the necessary config {{ (config('mail.driver') == 'sparkpost' or config('mail.driver') == 'mailgun') ? 'files' : 'file' }} for you.</p>

			<p>If you need to change your email configuration, you can either edit the <nobr><code>config/mail.php</code></nobr> file manually or delete the <nobr><code>config/mail.php</code></nobr> file and run this step of the installer again.</p>

			@if (config('mail.driver') == 'sparkpost' or config('mail.driver') == 'mailgun')
				<p>If you need to change how {{ config('nova.app.name') }} connects to the email API, you can either edit the <nobr><code>config/services.php</code></nobr> file manually or delete the <nobr><code>config/mail.php</code></nobr> and <nobr><code>config/services.php</code></nobr> files and run this step of the installer again.</p>
			@endif
		</div>
	</div>
@endsection

@section('controls')
	@if ($_setupType == 'install')
		<a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">
			Next: Install {{ config('nova.app.name') }}
		</a>
	@else
		<a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Migrate Nova 2</a>
	@endif
	<a href="{{ route('setup.'.$_setupType.'.config.email') }}" class="btn btn-link-secondary btn-lg">
		Back: Restart Email Settings
	</a>
@endsection