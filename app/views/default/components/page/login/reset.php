<?php echo Form::open('login/reset');?>
	<div class="control-group">
		<div class="controls">
			<input type="email" name="email" id="email" class="span6" placeholder="<?php echo ucwords(lang("email_address"));?>">
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			<input type="password" name="password" id="password" class="span6" placeholder="<?php echo ucwords(lang('short.new', lang('password')));?>">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button class="btn btn-primary btn-block btn-large"><?php echo ucfirst(lang('action.submit'));?></button>

			<div class="small-controls">
				<a href="<?php echo Uri::create('login/index');?>" class="btn btn-small btn-block"><?php echo lang('short.cancelPasswordReset');?></a>
			</div>
		</div>
	</div>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>