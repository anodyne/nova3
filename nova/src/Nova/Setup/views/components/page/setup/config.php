<?php if ($step == 0): ?>
	<p><?php echo $message;?></p>
<?php elseif ($step == 1): ?>
	<p><?php echo $message;?></p>
	
	<hr>
	
	<?php echo Form::open('setup/main/config/2');?>
		<label class="control-label">Database Name</label>
		<?php echo Form::input('dbName', Session::instance('fuelcid')->get('dbName', 'nova'));?>
		<p class="help-block">The name of the database you want me to install Nova into</p>
		
		<label class="control-label">Username</label>
		<?php echo Form::input('dbUser', Session::instance('fuelcid')->get('dbUser', 'username'));?>
		<p class="help-block">Your database username</p>
		
		<label class="control-label">Password</label>
		<?php echo Form::input('dbPass', Session::instance('fuelcid')->get('dbPass', 'password'));?>
		<p class="help-block">Your database password</p>
		
		<label class="control-label">Database Host</label>
		<?php echo Form::input('dbHost', Session::instance('fuelcid')->get('dbHost', 'localhost'));?>
		<p class="help-block">There's a 99% chance you won't need to change this</p>
		
		
		<label class="control-label">Table Prefix</label>
		<?php echo Form::input('prefix', Session::instance('fuelcid')->get('prefix', 'nova_'));?>
		<p class="help-block">The database table prefix I should use</p>

		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php elseif ($step == 2): ?>
	<p><?php echo $message;?></p>
<?php elseif ($step == 3): ?>
	<p><?php echo $message;?></p>
	
	<?php if (isset($code)): ?>
		<hr>
		
		<pre><?php echo $code;?></pre>
	<?php endif;?>
<?php elseif ($step == 4): ?>
	<p><?php echo $message;?></p>
<?php endif;?>