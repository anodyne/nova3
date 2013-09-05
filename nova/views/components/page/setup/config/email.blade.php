@if ($step === false)
	<p>{{ $message }}</p>
@elseif ($step == 'info')
	<p>{{ $message }}</p>

	<hr>
	
	{{ Form::open(['url' => 'setup/config/email/write']) }}
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label>Email Driver</label>
					<div>
						<label class="radio-inline"><input type="radio" name="driver" value="smtp" class="js-email-driver" checked="checked"> SMTP</label>
						<label class="radio-inline"><input type="radio" name="driver" value="mail" class="js-email-driver"> PHP Mail</label>
						<label class="radio-inline"><input type="radio" name="driver" value="sendmail" class="js-email-driver"> Sendmail</label>
					</div>
				</div>
			</div>
		</div>

		<div id="smtpOptions">
			<div class="row">
				<div class="col-lg-6">
					<label>SMTP Host</label>
					<input type="text" class="form-control" name="hostname" value="{{ Session::get('hostname', '') }}">
					<p class="help-block">The name of the SMTP server you'd like to use</p>
				</div>

				<div class="col-lg-3">
					<label>SMTP Port</label>
					<input type="text" class="form-control" name="port" value="{{ Session::get('port', '25') }}">
					<p class="help-block">The port to use for SMTP</p>
				</div>

				<div class="col-lg-3">
					<label>Encryption Protocol</label>
					<input type="text" class="form-control" name="encryption" value="{{ Session::get('encryption', 'tls') }}">
					<p class="help-block">The encryption protocol to use</p>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<label>Username</label>
					<input type="text" class="form-control" name="username" value="{{ Session::get('username', '') }}">
					<p class="help-block">Your SMTP username</p>
				</div>

				<div class="col-lg-6">
					<label>Password</label>
					<input type="text" class="form-control" name="password" value="{{ Session::get('password', '') }}">
					<p class="help-block">Your SMTP password</p>
				</div>
			</div>
		</div>

		<div id="sendmailOptions" class="hide">
			<div class="row">
				<div class="col-lg-4">
					<label>Sendmail Path</label>
					<input type="text" class="form-control" name="sendmailpath" value="{{ Session::get('sendmailpath', '/usr/sbin/sendmail -bs') }}">
					<p class="help-block">The path to Sendmail on the server</p>
				</div>
			</div>
		</div>
@elseif ($step == 'write')
	<p>{{ $message }}</p>
	
	@if (isset($code))
		<hr>
		
		<pre>{{ $code }}</pre>
	@endif
@endif