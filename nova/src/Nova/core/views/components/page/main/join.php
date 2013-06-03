<?php

if ( ! function_exists('joinData'))
{
	function joinData($field)
	{
		if (Sentry::check())
		{
			return Sentry::user()->{$field};
		}

		return false;
	}
}

?><form method="post" id="joinForm">
	<div class="btn-group pull-right hidden-phone">
		<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="prev" title="<?php echo ucfirst(langConcat('previous step'));?>"><div class="icn icn-50" data-icon="<"></div></a>
		<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="next" title="<?php echo ucfirst(langConcat('next step'));?>"><div class="icn icn-50" data-icon=">"></div></a>
	</div>

	<ul id="joinTabs" class="nav nav-pills hidden-phone">
		<li class="active"><a href="#user" data-toggle="pill"><?php echo ucwords(langConcat('user info'));?></a></li>
		<li><a href="#characterInfo" data-toggle="pill"><?php echo ucwords(langConcat('character info'));?></a></li>
		<li><a href="#characterForm" data-toggle="pill"><?php echo ucwords(langConcat('character bio'));?></a></li>
		
		<?php if ( ! empty($samplePostContent)): ?>
			<li><a href="#samplePost" data-toggle="pill"><?php echo ucwords(lang('sample_post'));?></a></li>
		<?php endif;?>
	</ul>

	<!-- These tabs are specific to mobile devices -->
	<ul id="joinTabs" class="nav nav-pills nav-stacked hidden-desktop hidden-tablet">
		<li class="active"><a href="#user" data-toggle="pill"><?php echo ucwords(langConcat('user info'));?></a></li>
		<li><a href="#characterInfo" data-toggle="pill"><?php echo ucwords(langConcat('character info'));?></a></li>
		<li><a href="#characterForm" data-toggle="pill"><?php echo ucwords(langConcat('character bio'));?></a></li>
		
		<?php if ( ! empty($samplePostContent)): ?>
			<li><a href="#samplePost" data-toggle="pill"><?php echo ucwords(lang('sample_post'));?></a></li>
		<?php endif;?>
	</ul>

	<div class="pill-content">
		<div id="user" class="pill-pane active">
			<div class="alert alert-info alert-block">
				<h4><?php echo ucwords(lang('short.pleaseNote'));?></h4>
				<p><?php echo ucfirst(lang('short.join.userInfo', lang('user'), lang('name'), lang('email_address'), lang('sim')));?></p>
			</div>

			<div class="alert alert-info alert-block hide" id="welcomeBack">
				<h4><?php echo ucwords(lang('short.join.welcomeBack'));?></h4>
				<p><?php echo lang('short.join.userFound', lang('user'), lang('character'), lang('game_master'));?></p>
				<p><?php echo lang('short.join.userFormReset', lang('user'));?></p>
			</div>

			<div class="row">
				<div id="userInfo" class="span6">
					<div class="control-group">
						<label class="control-label"><?php echo ucwords(lang('email_address'));?></label>
						<div class="controls">
							<input type="email" name="user[email]" id="emailField" class="span4" value="<?php echo joinData('email');?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
						<div class="controls">
							<input type="text" name="user[name]" class="span4" value="<?php echo joinData('name');?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo ucfirst(lang('password'));?></label>
						<div class="controls">
							<input type="password" name="user[password]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo ucwords(langConcat('action.confirm password'));?></label>
						<div class="controls">
							<input type="password" name="user[confirm_password]" class="span4">
						</div>
					</div>

					<?php echo $appForm;?>
				</div>

				<div id="userForm" class="span6"><?php echo $user;?></div>
			</div>
		</div>

		<div id="characterInfo" class="pill-pane">
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label"><?php echo ucwords(langConcat('first name'));?></label>
						<div class="controls">
							<input type="text" name="character[first_name]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo ucwords(langConcat('middle name'));?></label>
						<div class="controls">
							<input type="text" name="character[middle_name]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo ucwords(langConcat('last name'));?></label>
						<div class="controls">
							<input type="text" name="character[last_name]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo ucfirst(lang('suffix'));?></label>
						<div class="controls">
							<input type="text" name="character[suffix]" class="span2">
						</div>
					</div>

					<?php echo NovaForm::position('position', array(), array(), 'open');?>
				</div>

				<div class="span6 muted"><?php echo $characterJoinHelp;?></div>
			</div>
		</div>

		<div id="characterForm" class="pill-pane"><?php echo $character;?></div>

		<?php if ( ! empty($samplePostContent)): ?>
			<div id="samplePost" class="pill-pane">
				<div class="control-group">
					<label class="control-label"><?php echo Markdown::parse($samplePostContent);?></label>
					<div class="controls">
						<textarea name="sample_post" rows="15" class="span12"></textarea>
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>

	<div class="controls">
		<div class="btn-toolbar">
			<div class="btn-group">
				<button class="btn btn-primary" name="submit"><?php echo ucfirst(lang('action.submit'));?></button>
			</div>

			<div class="btn-group">
				<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="prev" title="<?php echo ucfirst(langConcat('previous step'));?>"><div class="icn icn-50" data-icon="<"></div></a>
				<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="next" title="<?php echo ucfirst(langConcat('next step'));?>"><div class="icn icn-50" data-icon=">"></div></a>
			</div>
		</div>
	</div>

	<input type="hidden" name="user[id]" value="0">
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
</form>