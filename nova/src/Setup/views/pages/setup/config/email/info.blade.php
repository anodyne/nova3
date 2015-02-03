@extends('layouts.setup')

@section('title')
	Email Settings
@stop

@section('header')
	Email Settings
@stop

@section('content')
	<h1>Configure Email Settings</h1>
	<h2>Tell us a little bit about how you want {{ config('nova.app.name') }} to send email</h2>

	{!! Form::open(['route' => "setup.{$_setupType}.config.email.write", 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('mail_driver')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Driver</label>
			<div class="col-md-7">
				<div class="radio">
					<label>
						{!! Form::radio('mail_driver', 'smtp', false) !!} SMTP Service <em class="text-success">(Recommended)</em>
					</label>
				</div>
				<div class="radio">
					<label>
						{!! Form::radio('mail_driver', 'sendmail', false) !!} Sendmail
					</label>
				</div>
				<div class="radio">
					<label>
						{!! Form::radio('mail_driver', 'mail', false) !!} PHP Mail
					</label>
				</div>
				@if (app()->environment() == 'local')
					<div class="radio">
						<label>
							{!! Form::radio('mail_driver', 'log', false) !!} Log Files <em class="text-danger">(For development purposes only)</em>
						</label>
					</div>
				@endif
				{!! $errors->first('mail_driver', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div id="settings-smtp" class="hide">
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<h3>SMTP Service</h3>

					<p>Sending email through an SMTP service removes the onus for delivering email off of your web host and onto a third-party service. (Trust me, your web host will love you for it!) In most cases, SMTP email services are <em>far</em> more reliable at deliverying email and ensuring your messages aren't marked as spam. <strong class="text-success">We recommend using an SMTP email service to deliver email from {{ config('nova.app.name') }}.</strong></p>

					<p>Here are a list of free and/or cheap SMTP email services to check out:</p>

					<ul>
						<li><a href="http://www.mailgun.com/" target="_blank">Mailgun</a></li>
						<li><a href="http://mandrill.com/" target="_blank">Mandrill</a></li>
						<li><a href="https://postmarkapp.com/" target="_blank">Postmark</a></li>
						<li><a href="https://sendgrid.com/" target="_blank">SendGrid</a></li>

						@if (app()->environment() == 'local')
							<li><a href="https://sendgrid.com/" target="_blank">SendGrid</a></li>
						@endif
					</ul>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('mail_host')) ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">Host</label>
				<div class="col-md-7">
					{!! Form::text('mail_host', false, ['class' => 'input-lg form-control']) !!}
					{!! $errors->first('mail_host', '<p class="help-block">:message</p>') !!}
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
					{!! Form::text('mail_username', false, ['class' => 'input-lg form-control']) !!}
					{!! $errors->first('mail_username', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="form-group{{ ($errors->has('mail_password')) ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">Password</label>
				<div class="col-md-7">
					{!! Form::password('mail_password', ['class' => 'input-lg form-control']) !!}
					{!! $errors->first('mail_password', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>

		<div id="settings-sendmail" class="hide">
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<h3>Sendmail</h3>

					<p>Depending on your web host's setup, sending email through sendmail may be the same as sending through PHP's <code>mail()</code> function. If you have specific reasons to send email through sendmail or your web host recommends using sendmail instead of <code>mail()</code>, use this option.</p>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('mail_sendmail')) ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">Sendmail Path</label>
				<div class="col-md-7">
					{!! Form::text('mail_sendmail', '/usr/sbin/sendmail -bs', ['class' => 'input-lg form-control']) !!}
					{!! $errors->first('mail_sendmail', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>

		<div id="settings-phpmail" class="hide">
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<h3>PHP Mail</h3>

					<p>All previous versions of Nova have sent email through PHP's <code>mail()</code> function. It's the simplest email option available, requires no external services or information, and is enabled by default on most shared hosts. In the past though, we've run into issues with email not being delivered or being marked as spam. <strong class="text-danger">Use this option only as a last resort!</strong></p>
				</div>
			</div>
		</div>

		<div id="settings-log" class="hide">
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<h3>Mail Logging</h3>

					<p>When developing, you want to be able to test emails but not worry about them being sent out to recipients. With mail logging, all emails will be written to the log files for viewing. If you want to see the full output of your emails, consider an SMTP service like <a href="https://mailtrap.io/" target="_blank">MailTrap</a>. <strong class="text-danger">This option is only for development purposes!</strong></p>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-3">
				{!! Form::button('Set Email Settings', ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-link">Back: Database Connection</a></p>
		</div>
		<div class="col-md-6 text-right">
			@if (file_exists(app('path.config').'/mail.php'))
				<p><a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-primary">Next: Install {{ config('nova.app.name') }}</a></p>
			@else
				<p><a class="btn btn-link disabled">Next: Install {{ config('nova.app.name') }}</a></p>
			@endif
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$(function()
		{
			if ($('[name="mail_driver"]').is(':checked'))
			{
				doShowHide($('[name="mail_driver"]:checked').val());
			}
		});

		$('[name="mail_driver"]').on('change', function(e)
		{
			doShowHide($('[name="mail_driver"]:checked').val());
		});

		function doShowHide(selected)
		{
			if (selected == "smtp")
			{
				$('#settings-sendmail').addClass('hide');
				$('#settings-phpmail').addClass('hide');
				$('#settings-log').addClass('hide');
				$('#settings-smtp').removeClass('hide');
			}

			if (selected == "sendmail")
			{
				$('#settings-smtp').addClass('hide');
				$('#settings-phpmail').addClass('hide');
				$('#settings-log').addClass('hide');
				$('#settings-sendmail').removeClass('hide');
			}

			if (selected == "mail")
			{
				$('#settings-smtp').addClass('hide');
				$('#settings-sendmail').addClass('hide');
				$('#settings-log').addClass('hide');
				$('#settings-phpmail').removeClass('hide');
			}

			if (selected == "log")
			{
				$('#settings-smtp').addClass('hide');
				$('#settings-sendmail').addClass('hide');
				$('#settings-phpmail').addClass('hide');
				$('#settings-log').removeClass('hide');
			}
		}
	</script>
@stop