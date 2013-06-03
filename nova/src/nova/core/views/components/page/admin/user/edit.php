<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/user/index');?>" class="btn tooltip-top" title="<?php echo ucfirst(lang('short.back', langConcat('all users')));?>"><div class="icn icn16 icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn tooltip-top" title="<?php echo ucfirst(lang('action.request loa'));?>"><div class="icn icn16 icn-75" data-icon="#"></div></a>
	</div>
</div>

<div class="row">
	<div class="span9">
		<ul class="nav nav-pills">
			<li class="active"><a href="#userInfo" data-toggle="pill"><?php echo ucfirst(lang('info'));?></a></li>
			<li><a href="#userPrefs" data-toggle="pill"><?php echo ucfirst(lang('preferences'));?></a></li>

			<?php if (Sentry::user()->hasLevel('user.update', 2)): ?>
				<li><a href="#userAdmin" data-toggle="pill"><?php echo ucfirst(lang('admin'));?></a></li>
			<?php endif;?>
		</ul>

		<div class="pill-content">
			<div id="userInfo" class="pill-pane active">
				<?php echo Form::open(array('id' => 'userInfoForm'));?>
					<fieldset>
						<legend><?php echo ucwords(langConcat('basic info'));?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
							<div class="controls">
								<input type="text" name="basic[name]" class="span4" value="<?php echo $user->name;?>">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucwords(lang('email_address'));?></label>
							<div class="controls">
								<input type="email" name="basic[email]" class="span4" value="<?php echo $user->email;?>">
							</div>
						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucfirst(lang('password'));?></label>
									<div class="controls">
										<input type="password" name="basic[password]" class="span4">
									</div>
								</div>
							</div>

							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucwords(langConcat('action.confirm password'));?></label>
									<div class="controls">
										<input type="password" name="basic[confirm_password]" class="span4">
									</div>
								</div>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend><?php echo ucwords(lang('user bio'));?></legend>

						<?php echo $userForm;?>
					</fieldset>

					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
					</div>

					<?php echo Form::hidden('action', 'basic');?>
					<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
				<?php echo Form::close();?>
			</div>

			<div id="userPrefs" class="pill-pane">
				<?php echo Form::open();?>
					<fieldset>
						<legend><?php echo ucwords(langConcat('general preferences'));?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo ucfirst(lang('timezone'));?></label>
							<div class="controls">
								<?php echo NovaForm::timezones('timezone', $prefs['timezone'], array('class' => 'span4'));?>
							</div>
						</div>

						<?php if (count(File::read_dir(APPPATH.'lang', 1, null)) > 1): ?>
							<div class="control-group">
								<label class="control-label"><?php echo ucfirst(lang('language'));?></label>
								<div class="controls">
									<?php echo NovaForm::languages('language', $prefs['language'], array('class' => 'span4'));?>
								</div>
							</div>
						<?php endif;?>
					</fieldset>

					<fieldset>
						<legend><?php echo ucwords(langConcat('site preferences'));?></legend>

						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucfirst(lang('rank'));?></label>
									<div class="controls">
										<?php echo Form::select('rank', $prefs['rank'], $ranks, array('class' => 'span4', 'id' => 'rankSet'));?>
									</div>
								</div>
							</div>
							<div class="span4">
								<label class="control-label">&nbsp;</label>
								<div id="rankImage"><?php Request::forge('ajax/info/rank_preview/'.$prefs['rank'])->execute();?></div>
							</div>
						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucwords(langConcat('main skin'));?></label>
									<div class="controls">
										<?php echo Form::select('skin_main', $prefs['skin_main'], $skinMain, array('class' => 'span4', 'id' => 'skinMain'));?>
									</div>
								</div>
							</div>
							<div class="span4">
								<label class="control-label">&nbsp;</label>
								<div id="skinMainImage"><?php Request::forge('ajax/info/skin_preview/main/'.$prefs['skin_main'])->execute();?></div>
							</div>
						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucwords(langConcat('admin skin'));?></label>
									<div class="controls">
										<?php echo Form::select('skin_admin', $prefs['skin_admin'], $skinAdmin, array('class' => 'span4', 'id' => 'skinAdmin'));?>
									</div>
								</div>
							</div>
							<div class="span4">
								<label class="control-label">&nbsp;</label>
								<div id="skinAdminImage"><?php Request::forge('ajax/info/skin_preview/admin/'.$prefs['skin_admin'])->execute();?></div>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend><?php echo ucwords(langConcat('email_short and email_short notification preferences'));?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo ucwords(langConcat('email_short format'));?></label>
							<div class="controls">
								<?php echo Form::select('email_format', $prefs['email_format'], array('html' => 'HTML', 'text' => lang('text', 1)), array('class' => 'span2'));?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucfirst(lang('comments'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notifyComments', lang('comment'), lang('mission_post'), lang('personal_log'), lang('announcement'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_comments', 1, $prefs['email_comments']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_comments', 0, $prefs['email_comments']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucfirst(lang('messages'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notifyMessages', lang('messages'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_messages', 1, $prefs['email_messages']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_messages', 0, $prefs['email_messages']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucwords(lang('personal_logs'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notify', lang('personal_log'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_logs', 1, $prefs['email_logs']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_logs', 0, $prefs['email_logs']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucfirst(lang('announcements'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notify', lang('announcement'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_announcements', 1, $prefs['email_announcements']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_announcements', 0, $prefs['email_announcements']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucwords(lang('mission_posts'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notify', lang('mission_post'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_posts', 1, $prefs['email_posts']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_posts', 0, $prefs['email_posts']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucwords(langConcat('joint mission_posts action.saved'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notifyPostsAction', lang('mission_post'), lang('action.updated'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_posts_save', 1, $prefs['email_posts_save']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_posts_save', 0, $prefs['email_posts_save']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo ucwords(langConcat('joint mission_posts action.deleted'));?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('email.help.notify', lang('mission_post'), lang('action.deleted'));?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_posts_delete', 1, $prefs['email_posts_delete']).' '.ucfirst(lang('yes'));?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_posts_delete', 0, $prefs['email_posts_delete']).' '.ucfirst(lang('no'));?>
								</label>
							</div>
						</div>
					</fieldset>

					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
					</div>

					<?php echo Form::hidden('action', 'preferences');?>
					<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
				<?php echo Form::close();?>
			</div>

			<?php if (Sentry::user()->hasLevel('user.update', 2)): ?>
				<div id="userAdmin" class="pill-pane"></div>
			<?php endif;?>
		</div>
	</div>

	<div class="span3">
		<p><img alt="" src="http://placehold.it/260x260" class="img-circle"></p>

		<a href="#" class="btn btn-block"><?php echo ucwords(lang('short.edit', lang('image')));?></a>
	</div>
</div>