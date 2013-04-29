@if ($step === false)
	<p>{{ $message }}</p>
@elseif ($step == 'info')
	<p>{{ $message }}</p>

	<hr>
	
	{{ Form::open(array('url' => 'setup/config/email/write')) }}
		<div class="row">
			<div class="col col-lg-12">
				<div class="control-group">
					<label class="control-label">Email Driver</label>
					<div class="controls">
						<label class="radio radio-inline"><input type="radio" name="driver" value="smtp" checked="checked"> SMTP</label>
						<label class="radio radio-inline"><input type="radio" name="driver" value="mail"> PHP Mail</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-6">
				<label class="control-label">SMTP Host</label>
				<input type="text" class="span10" name="hostname" value="{{ Session::get('hostname', '') }}">
				<p class="help-block">The name of the SMTP server you'd like to use</p>
			</div>

			<div class="col col-lg-3">
				<label class="control-label">SMTP Port</label>
				<input type="text" class="span5" name="port" value="{{ Session::get('port', '25') }}">
				<p class="help-block">The port to use for SMTP</p>
			</div>

			<div class="col col-lg-3">
				<label class="control-label">Encryption Protocol</label>
				<input type="text" class="span5" name="encryption" value="{{ Session::get('encryption', 'tls') }}">
				<p class="help-block">The encryption protocol to be used</p>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-6">
				<label class="control-label">Username</label>
				<input type="text" class="span10" name="username" value="{{ Session::get('username', '') }}">
				<p class="help-block">Your SMTP username</p>
			</div>

			<div class="col col-lg-6">
				<label class="control-label">Password</label>
				<input type="text" class="span10" name="password" value="{{ Session::get('password', '') }}">
				<p class="help-block">Your SMTP password</p>
			</div>
		</div>
@elseif ($step == 'write')
	<p>{{ $message }}</p>
	
	@if (isset($code))
		<hr>
		
		<pre>{{ $code }}</pre>
	@endif
@endif