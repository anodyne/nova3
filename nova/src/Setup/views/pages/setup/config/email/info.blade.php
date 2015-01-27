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
		<div class="form-group">
			<label class="col-md-3 control-label">Driver</label>
			<div class="col-md-7">
				<div class="radio">
					<label>
						{!! Form::radio('mail_driver', 'smtp', false) !!} SMTP Service <em>(recommended)</em>
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
			</div>
		</div>

		<div id="settings-smtp" class="hide">
			<h3>SMTP Email</h3>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce magna enim, volutpat vel porttitor vitae, iaculis quis mauris. Donec eleifend viverra mauris, in congue quam posuere a. Phasellus sem nisl, dapibus sit amet dolor non, molestie condimentum nisl. Nam eget consequat ex, eget hendrerit sem. Proin malesuada a est at elementum. Duis eget pharetra arcu.</p>

			<hr class="partial">

			<div class="form-group">
				<label class="col-md-3 control-label">Host</label>
				<div class="col-md-7">
					{!! Form::text('mail_host', false, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Port</label>
				<div class="col-md-7">
					{!! Form::text('mail_port', 587, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Encryption</label>
				<div class="col-md-7">
					{!! Form::text('mail_encryption', 'tls', ['class' => 'input-lg form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Username</label>
				<div class="col-md-7">
					{!! Form::text('mail_username', false, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Password</label>
				<div class="col-md-7">
					{!! Form::text('mail_password', false, ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
		</div>

		<div id="settings-sendmail" class="hide">
			<h3>Sendmail</h3>

			<p>Depending on your web host's setup, sending email through sendmail may be the same as sending through PHP's <code>mail()</code> function. If you have specific reasons to send email through sendmail or your web host recommends using sendmail instead of <code>mail()</code>, use this option.</p>

			<hr class="partial">

			<div class="form-group">
				<label class="col-md-3 control-label">Sendmail Path</label>
				<div class="col-md-7">
					{!! Form::text('mail_sendmail', '/usr/sbin/sendmail -bs', ['class' => 'input-lg form-control']) !!}
				</div>
			</div>
		</div>

		<div id="settings-phpmail" class="hide">
			<h3>PHP Mail</h3>

			<p>This is the way that previous versions of Nova have sent email. It's the simplest email option available, requires no external services or information, and is enabled on most servers. In the past though, we've run into issues with email not being delivered or marked as spam or other general issues with email. <strong class="text-error">Use this option only as a last resort!</strong></p>
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
				<p><a href="#" class="btn btn-primary">Next: Install {{ config('nova.app.name') }}</a></p>
			@else
				<p><a class="btn btn-link disabled">Next: Install {{ config('nova.app.name') }}</a></p>
			@endif
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$('[name="mail_driver"]').on('change', function(e)
		{
			var selected = $('[name="mail_driver"]:checked').val();

			if (selected == "smtp")
			{
				$('#settings-sendmail').addClass('hide');
				$('#settings-phpmail').addClass('hide');
				$('#settings-smtp').removeClass('hide');
			}

			if (selected == "sendmail")
			{
				$('#settings-smtp').addClass('hide');
				$('#settings-phpmail').addClass('hide');
				$('#settings-sendmail').removeClass('hide');
			}

			if (selected == "mail")
			{
				$('#settings-smtp').addClass('hide');
				$('#settings-sendmail').addClass('hide');
				$('#settings-phpmail').removeClass('hide');
			}
		});
	</script>
@stop