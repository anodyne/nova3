<?php if ($id == Model_Access_Role::SYSADMIN): ?>
	<div class="alert alert-block alert-danger">
		<h4><?php echo lang('short.roles.duplicateSysAdminHeader');?></h4>
		<p><?php echo lang('short.roles.duplicateSysAdminText', lang('users'));?></p>
	</div>
<?php endif;?>
<form method="post">
	<div class="control-group">
		<label class="control-label"><?php echo ucwords(langConcat('original role'));?></label>
		<div class="controls"><?php echo $name;?></div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucwords(langConcat('new name'));?></label>
		<div class="controls">
			<input type="text" name="name" class="span4">
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'duplicate');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>