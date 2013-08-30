@if ($step === false)
	<p>{{ $message }}</p>
@elseif ($step == 'info')
	<p>{{ $message }}</p>
	
	{{ Form::open(['url' => 'setup/config/db/check']) }}
		<div class="row">
			<div class="col col-lg-6">
				<label>Database Name</label>
				<input type="text" class="form-control" name="dbName" value="{{ Session::get('dbName', '') }}">
				<p class="help-block">The name of the database you're installing Nova into</p>
			</div>

			<div class="col col-lg-6">
				<label>Database Host</label>
				<input type="text" class="form-control" name="dbHost" value="{{ Session::get('dbHost', 'localhost') }}">
				<p class="help-block">You most likely won't need to change this</p>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-6">
				<label>Username</label>
				<input type="text" class="form-control" name="dbUser" value="{{ Session::get('dbUser', '') }}">
				<p class="help-block">Your database username</p>
			</div>

			<div class="col col-lg-6">
				<label>Password</label>
				<input type="text" class="form-control" name="dbPass" value="{{ Session::get('dbPass', '') }}">
				<p class="help-block">Your database password</p>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-6">
				<label>Table Prefix</label>
				<input type="text" class="form-control" name="prefix" value="{{ Session::get('prefix', 'nova_') }}">
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