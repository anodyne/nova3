<p><?php echo lang('short.users.add', lang('user'), lang('name'), lang('email_address'), lang('password'), lang('characters'));?></p>

<?php echo Form::open();?>
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
		<div class="controls">
			<input type="text" name="name" value="" class="span4">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucwords(lang('email_address'));?></label>
		<div class="controls">
			<input type="email" name="email" value="" class="span4">
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.create'));?></button>
	</div>

	<?php echo Form::hidden('action', 'create');?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>