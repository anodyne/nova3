@if ($step === false)
	<p>{{ $message }}</p>
@elseif ($step == 'info')
	<p>{{ $message }}</p>
	
	{{ Form::open(array('url' => 'setup/config/db/check')) }}
		<div class="row-fluid">
			<div class="span6">
				<label class="control-label">Database Name</label>
				<input type="text" class="span10" name="dbName" value="{{ Session::get('dbName', '') }}">
				<p class="help-block">The name of the database you're installing Nova into</p>
			</div>

			<div class="span6">
				<label class="control-label">Database Host</label>
				<input type="text" class="span10" name="dbHost" value="{{ Session::get('dbHost', 'localhost') }}">
				<p class="help-block">You most likely won't need to change this</p>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<label class="control-label">Username</label>
				<input type="text" class="span10" name="dbUser" value="{{ Session::get('dbUser', '') }}">
				<p class="help-block">Your database username</p>
			</div>

			<div class="span6">
				<label class="control-label">Password</label>
				<input type="text" class="span10" name="dbPass" value="{{ Session::get('dbPass', '') }}">
				<p class="help-block">Your database password</p>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<label class="control-label">Table Prefix</label>
				<input type="text" class="span10" name="prefix" value="{{ Session::get('prefix', 'nova_') }}">
				<p class="help-block">The database table prefix to be used</p>
			</div>
		</div>
@elseif ($step == 'write')
	<p>{{ $message }}</p>
	
	@if (isset($code))
		<hr>
		
		<pre>{{ $code }}</pre>
	@endif
@endif