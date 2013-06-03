<?php echo Form::open();?>
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('user'));?></label>
		<div class="controls">
			<?php echo NovaForm::users('user', array(), array('class' => 'span5 chzn'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('character'));?></label>
		<div class="controls">
			<?php echo NovaForm::characters('character', array(), array('class' => 'span5 chzn'), 'active', true);?>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox"><input type="checkbox" name="make_main" value="yes"> <?php echo ucfirst(langConcat('action.make primary character'));?></label>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox"><input type="checkbox" name="override" value="yes"> <?php echo ucfirst(langConcat('action.override previous user'));?></label>
			<p class="help-block"><?php echo lang('short.users.override', lang('character'), lang('user'));?></p>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('action', 'link');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
<?php echo Form::close();?>