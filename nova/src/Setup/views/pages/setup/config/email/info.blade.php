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
		{!! Form::open(['route' => "setup.{$_setupType}.config.email.write", 'class' => 'form-horizontal']) !!}
			<div class="form-group{{ ($errors->has('mail_driver')) ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">Driver</label>
				<div class="col-md-7">
					<div class="radio">
						<label>
							{!! Form::radio('mail_driver', 'smtp', false, ['v-model' => 'driver']) !!} SMTP Service
							&nbsp;&nbsp;
							{!! label('success', 'Recommended') !!}
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('mail_driver', 'sendmail', false, ['v-model' => 'driver']) !!} Sendmail
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('mail_driver', 'mail', false, ['v-model' => 'driver']) !!} PHP Mail
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('mail_driver', 'mailgun', false, ['v-model' => 'driver']) !!} Mailgun API
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('mail_driver', 'sparkpost', false, ['v-model' => 'driver']) !!} SparkPost API
						</label>
					</div>
					@if (app('env') == 'local')
						<div class="radio">
							<label>
								{!! Form::radio('mail_driver', 'log', false, ['v-model' => 'driver']) !!} Log Files
								&nbsp;&nbsp;
								{!! label('danger', 'For development purposes only') !!}
							</label>
						</div>
					@endif
					{!! $errors->first('mail_driver', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div v-show="driver == 'smtp'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>SMTP Service</h2>

						<p>Sending email through an SMTP service removes the onus for delivering email off of your web host and onto a third-party service. (Trust me, your web host will love you for it!) In most cases, SMTP email services are <em>far</em> more reliable at deliverying email and ensuring your messages aren't marked as spam. <strong class="text-success">We recommend using an SMTP email service to deliver email from {{ config('nova.app.name') }}.</strong></p>

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

				<div class="form-group{{ ($errors->has('mail_host')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Host</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('mail_host', false, ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('mail_host', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group{{ ($errors->has('mail_port')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Port</label>
					<div class="col-md-2">
						{!! Form::text('mail_port', 587, ['class' => 'input-lg form-control']) !!}
					</div>
					<div class="col-md-5">
						{!! $errors->first('mail_port', '<p class="help-block">:message</p>') !!}
					</div>
				</div>

				<div class="form-group{{ ($errors->has('mail_encryption')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Encryption</label>
					<div class="col-md-2">
						{!! Form::text('mail_encryption', 'tls', ['class' => 'input-lg form-control']) !!}
					</div>
					<div class="col-md-5">
						{!! $errors->first('mail_encryption', '<p class="help-block">:message</p>') !!}
					</div>
				</div>

				<div class="form-group{{ ($errors->has('mail_username')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Username</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('mail_username', false, ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('mail_username', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group{{ ($errors->has('mail_password')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Password</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::password('mail_password', ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('mail_password', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver == 'sendmail'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>Sendmail</h2>

						<p>Depending on your web host's setup, sending email through sendmail may be the same as sending through PHP's <code>mail()</code> function. If you have specific reasons to send email through sendmail or your web host recommends using sendmail instead of <code>mail()</code>, use this option.</p>
					</div>
				</div>

				<div class="form-group{{ ($errors->has('mail_sendmail')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Sendmail Path</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('mail_sendmail', '/usr/sbin/sendmail -bs', ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('mail_sendmail', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver == 'mail'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>PHP Mail</h2>

						<p>All previous versions of Nova have sent email through PHP's <code>mail()</code> function. It's the simplest email option available, requires no external services or information, and is enabled by default on most shared hosts. In the past though, we've run into issues with email not being delivered or being marked as spam. <strong class="text-danger">Use this option only as a last resort!</strong></p>
					</div>
				</div>
			</div>

			<div v-show="driver == 'log'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>Mail Logging</h2>

						<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a> or <a href="https://debugmail.io/" target="_blank">Debug Mail</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
					</div>
				</div>
			</div>

			<div v-show="driver == 'mailgun'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>Mailgun API</h2>

						<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a> or <a href="https://debugmail.io/" target="_blank">Debug Mail</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
					</div>
				</div>

				<div class="form-group{{ ($errors->has('services_mailgun_domain')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Domain</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('services_mailgun_domain', null, ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('services_mailgun_domain', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group{{ ($errors->has('services_mailgun_secret')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Secret Key</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('services_mailgun_secret', null, ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('services_mailgun_secret', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver == 'sparkpost'">
				<div class="form-group">
					<div class="col-md-8 col-md-offset-3">
						<h2>SparkPost API</h2>

						<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a> or <a href="https://debugmail.io/" target="_blank">Debug Mail</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
					</div>
				</div>

				<div class="form-group{{ ($errors->has('services_sparkpost_secret')) ? ' has-error' : '' }}">
					<label class="col-md-3 control-label">Secret Key</label>
					<div class="col-md-7">
						<div class="control-wrapper">
							{!! Form::text('services_sparkpost_secret', null, ['class' => 'input-lg form-control']) !!}
							{!! $errors->first('services_sparkpost_secret', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>

			<div v-show="driver">
				<div class="form-group">
					<div class="col-md-7 col-md-offset-3">
						{!! Form::button('Set Email Settings', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 col-sm-push-6 text-right">
			@if (file_exists(app('path.config').'/mail.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary btn-lg">Next: Install {{ config('nova.app.name') }}</a></p>
			@else
				<p><a class="btn btn-link btn-lg disabled">Next: Install {{ config('nova.app.name') }}</a></p>
			@endif
		</div>
		<div class="col-sm-6 col-sm-pull-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-link btn-lg">Back: Restart Database Connection</a></p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		var vm = new Vue({
			el: "#app",

			data: {
				'driver': false
			}
		})
	</script>
@stop