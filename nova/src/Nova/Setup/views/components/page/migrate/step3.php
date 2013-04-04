<?php echo Form::open('setup/upgrade/index/4');?>
	<h2>Setup New Password</h2>

	<p>Nova 3 uses an enhanced level of encryption on passwords to ensure they can't easily be cracked. Unfortunately, updating existing passwords to the new encryption isn't possible. Like previous upgrades, please provide a temporary password that everyone will be reset to. Once a user logs in the first time, they'll be prompted to change their password to something they can remember.</p>

	<div class="controls">
		<label class="control-label">Temporary Password</label>
		<input type="text" name="password">&nbsp;
		<span class="hide"><?php echo Html::img($image['loading']['src'], $image['loading']['attr']);?></span>
		<span class="hide" id="password-success"><?php echo Html::img($image['success']['src'], $image['success']['attr']);?></span>
	</div>

	<h2>Setup System Administrators</h2>

	<p>Nova 3 uses a brand-new authentication and access control system that puts even more control in the game master's hands. Sadly, the new system is incompatible with the old system. Please specify who you'd like to be a system administrator for this site. We recommend starting with just one or two people. You can add more system administrators after the system is upgraded and ready to use.</p>

	<div class="controls">
		<label class="control-label">Select System Administrator(s)</label>
		<?php echo Form::select('admins', null, $users, array('multiple' => 'multiple', 'style' => 'height: 200px', 'class' => 'span6'));?>&nbsp;
		<span class="hide"><?php echo Html::img($image['loading']['src'], $image['loading']['attr']);?></span>
		<span class="hide" id="admins-success"><?php echo Html::img($image['success']['src'], $image['success']['attr']);?></span>
	</div>