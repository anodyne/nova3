<?php if ($lockout === false): ?>
	<?php echo Form::open('login/index');?>
		<div class="control-group">
			<div class="controls">
				<input type="email" name="email" id="email" class="span6" placeholder="<?php echo ucwords(lang("email_address"));?>">
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<input type="password" name="password" id="password" class="span6" placeholder="<?php echo ucfirst(lang("password"));?>">
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<button class="btn btn-primary btn-block btn-large"><?php echo ucwords(lang('action.login'));?></button>

				<div class="row-fluid small-controls">
					<div class="span6"><a href="<?php echo Uri::create('login/reset');?>" class="btn btn-small btn-block"><?php echo lang("short.forgotPassword");?></a></div>
					<div class="span6"><a href="<?php echo Uri::create('main/index');?>" class="btn btn-small btn-block"><?php echo lang('short.backToSite');?></a></div>
				</div>
			</div>
		</div>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo Form::close();?>
<?php endif;?>