@extends('layouts.setup')

@section('title')
	Email Settings
@stop

@section('header')
	Email Settings
@stop

@section('content')
	<h1>Configure Email Settings</h1>
	<h3>Tell us a little bit about how you want {{ config('nova.app.name') }} to send email</h3>

	<div v-cloak>
		{!! Form::open(['route' => "setup.{$_setupType}.config.email.write"]) !!}
			<div :class="driverClassName">
				<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Driver</label>
				<div class="col-md-6 col-lg-5">
					<div class="control-wrapper">
						<select name="mail_driver" class="form-control form-control-lg" v-model="driver">
							<option value="smtp">SMTP Service</option>
							<option value="sendmail">Sendmail</option>
							<option value="mail">PHP Mail</option>
							<option value="mailgun">Mailgun API</option>
							<option value="sparkpost">SparkPost API</option>

							@if (app('env') == 'local')
								<option value="log">Log Files</option>
							@endif
						</select>

						<p class="form-text" v-show="driver == 'log'">For development purposes only</p>
						<p class="form-text" v-show="driver == 'smtp'">Recommended</p>
						<p class="form-text" v-show="driver == 'mail'">Not recommended</p>
					</div>
				</div>
			</div>

			<div v-show="driver == 'smtp'">
				<div class="form-group row">
					<div class="col-lg-10 offset-lg-1">
						<h2>SMTP Service</h2>

						<p>Sending email through an SMTP service removes the onus for delivering email off of your web host and onto a third-party service. (Trust us, your web host will love you for it!) In most cases, SMTP email services are <em>far</em> more reliable at deliverying email and ensuring your messages aren't marked as spam. <strong class="text-success">We recommend using an SMTP email service to deliver email from {{ config('nova.app.name') }}.</strong></p>

						<p>Here are a list of free and/or cheap SMTP email services to check out:</p>

						<ul>
							<li><a href="http://www.mailgun.com/" target="_blank">Mailgun</a></li>
							<li><a href="https://postmarkapp.com/" target="_blank">Postmark</a></li>
							<li><a href="https://sendgrid.com/" target="_blank">SendGrid</a></li>
							<li><a href="https://www.sparkpost.com/" target="_blank">SparkPost</a></li>

							@if (app()->environment() == 'local')
								<li><a href="https://mailtrap.io/" target="_blank">MailTrap</a></li>
								<li><a href="https://debugmail.io/" target="_blank">Debug Mail</a></li>
							@endif
						</ul>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('mail_host')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Host</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::text('mail_host', false, ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('mail_host', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('mail_port')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Port</label>
					<div class="col-md-2">
						{!! Form::text('mail_port', 587, ['class' => 'form-control form-control-lg']) !!}
					</div>
					<div class="col-md-5">
						{!! $errors->first('mail_port', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('mail_encryption')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Encryption</label>
					<div class="col-md-2">
						{!! Form::text('mail_encryption', 'tls', ['class' => 'form-control form-control-lg']) !!}
					</div>
					<div class="col-md-5">
						{!! $errors->first('mail_encryption', '<p class="form-control-feedback">:message</p>') !!}
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('mail_username')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Username</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::text('mail_username', false, ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('mail_username', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('mail_password')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Password</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::password('mail_password', ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('mail_password', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver == 'sendmail'">
				<div class="form-group row">
					<div class="col-lg-10 offset-lg-1">
						<h2>Sendmail</h2>

						<p>Depending on your web host's setup, sending email through sendmail may be the same as sending through PHP's <code>mail()</code> function. If you have specific reasons to send email through sendmail or your web host recommends using sendmail instead of <code>mail()</code>, use this option.</p>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('mail_sendmail')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Sendmail Path</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::text('mail_sendmail', '/usr/sbin/sendmail -bs', ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('mail_sendmail', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver == 'mail'">
				<div class="form-group row">
					<div class="col-lg-10 offset-lg-1">
						<h2>PHP Mail</h2>

						<p>All previous versions of Nova have sent email through PHP's <code>mail()</code> function. It's the simplest email option available, requires no external services or information, and is enabled by default on most shared hosts. In the past though, we've run into significant issues with email not being delivered or being marked as spam. <strong class="text-warning">Use this option only as a last resort!</strong></p>
					</div>
				</div>
			</div>

			<div v-show="driver == 'log'">
				<div class="form-group row">
					<div class="col-lg-10 offset-lg-1">
						<h2>Mail Logging</h2>

						<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a> or <a href="https://debugmail.io/" target="_blank">Debug Mail</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
					</div>
				</div>
			</div>

			<div v-show="driver == 'mailgun'">
				<div class="form-group row">
					<div class="col-lg-10 offset-lg-1">
						<h2>Mailgun API</h2>

						<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a> or <a href="https://debugmail.io/" target="_blank">Debug Mail</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('services_mailgun_domain')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Domain</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::text('services_mailgun_domain', null, ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('services_mailgun_domain', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('services_mailgun_secret')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Secret Key</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::text('services_mailgun_secret', null, ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('services_mailgun_secret', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver == 'sparkpost'">
				<div class="form-group row">
					<div class="col-lg-10 offset-lg-1">
						<h2>SparkPost API</h2>

						<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a> or <a href="https://debugmail.io/" target="_blank">Debug Mail</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
					</div>
				</div>

				<div class="form-group row{{ ($errors->has('services_sparkpost_secret')) ? ' has-error' : '' }}">
					<label class="col-md-4 col-lg-3 col-form-label col-form-label-lg">Secret Key</label>
					<div class="col-md-8 col-lg-7">
						<div class="control-wrapper">
							{!! Form::text('services_sparkpost_secret', null, ['class' => 'form-control form-control-lg']) !!}
							{!! $errors->first('services_sparkpost_secret', '<p class="form-control-feedback">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver">
				<div class="form-group row">
					<div class="col-md-8 offset-md-4 col-lg-9 offset-lg-3">
						{!! Form::button('Set Email Settings', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			@if (file_exists(app('path.config').'/mail.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Install {{ config('nova.app.name') }}</a></p>
			@else
				<p><a class="btn btn-link btn-lg disabled">Next: Install {{ config('nova.app.name') }}</a></p>
			@endif
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-link btn-lg">Back: Restart Database Connection</a></p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		app = {
			data: {
				'driver': false
			},

			computed: {
				driverClassName: function () {
					if (this.driver == 'smtp') {
						return 'form-group row has-success'
					}

					if (this.driver == 'mail') {
						return 'form-group row has-warning'
					}

					if (this.driver == 'log') {
						return 'form-group row has-danger'
					}

					return 'form-group row'
				}
			}
		}
	</script>
@stop