<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/user') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn btn-default tooltip-top icn-size-16" title="{{ langConcat('Action.request loa') }}">{{ $_icons['clock'] }}</a>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-lg-3 col-md-push-9 col-lg-push-9">
		<p class="visible-xs visible-sm visible-lg text-center"><img alt="" src="http://placehold.it/260x260" class="img-circle"></p>

		<p class="visible-md text-center"><img alt="" src="http://placehold.it/200x200" class="img-circle"></p>

		<div class="visible-md visible-lg">
			<a href="#" class="btn btn-default btn-block">{{ lang('Short.edit', lang('Image')) }}</a>
		</div>
	</div>

	<div class="col-md-9 col-lg-9 col-md-pull-3 col-lg-pull-3">
		<ul class="nav nav-pills">
			<li class="active"><a href="#userInfo" data-toggle="pill">{{ lang('Info') }}</a></li>
			<li><a href="#userBio" data-toggle="pill">{{ lang('Bio') }}</a></li>
			<li><a href="#userPrefs" data-toggle="pill">{{ lang('Preferences') }}</a></li>
			<li><a href="#emailNotifications" data-toggle="pill">{{ langConcat('Email_short Notifications') }}</a></li>

			@if ($_currentUser->hasLevel('user.update', 2))
				<li><a href="#userAdmin" data-toggle="pill">{{ lang('Admin') }}</a></li>
			@endif
		</ul>

		<div class="pill-content">
			<div id="userInfo" class="pill-pane active">
				{{ Form::model($user, ['url' => "admin/user/edit/{$user->id}", 'id' => 'userInfoForm']) }}
					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ lang('Name') }}</label>
								{{ Form::text('name', null, ['class' => 'form-control']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ ucwords(lang('email_address')) }}</label>
								{{ Form::email('email', null, ['class' => 'form-control']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">{{ langConcat('Action.change Your Password') }}</h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label">{{ langConcat('Current Password') }}</label>
										{{ Form::password('password', ['class' => 'form-control']) }}
									</div>

									<div class="form-group">
										<label class="control-label">{{ langConcat('New Password') }}</label>
										{{ Form::password('password_new', ['class' => 'form-control']) }}
									</div>

									<div class="form-group">
										<label class="control-label">{{ langConcat('Action.confirm New Password') }}</label>
										{{ Form::password('password_new_confirm', ['class' => 'form-control']) }}
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							{{ Form::token() }}
							{{ Form::hidden('id') }}
							{{ Form::hidden('formAction', 'basic') }}
							
							{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>

			<div id="userBio" class="pill-pane">
				{{ Form::model($user, ['url' => "admin/user/edit/{$user->id}", 'id' => 'userInfoForm']) }}
					{{ $user->getDynamicForm(true) }}

					<div class="row">
						<div class="col-lg-12">
							{{ Form::token() }}
							{{ Form::hidden('id') }}
							{{ Form::hidden('formAction', 'bio') }}
							
							{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>

			<div id="userPrefs" class="pill-pane">
				{{ Form::model($user, ['url' => "admin/user/edit/{$user->id}"]) }}
					<fieldset>
						<legend>{{ langConcat('General Preferences') }}</legend>

						<div class="row">
							<div class="col-md-8 col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ lang('Timezone') }}</label>
									{{ Form::timezones('timezone', $user->getPreferenceItem('timezone'), ['class' => 'form-control']) }}
								</div>
							</div>
						</div>

						@if (count($languageDir) > 1)
							<div class="row">
								<div class="col-md-8 col-lg-6">
									<div class="form-group">
										<label class="control-label">{{ lang('Language') }}</label>
										{{ Form::languages('language', $user->getPreferenceItem('language'), ['class' => 'form-control']) }}
									</div>
								</div>
							</div>
						@endif

						<div class="row">
							<div class="col-md-4 col-lg-3">
								<div class="form-group">
									<label class="control-label">{{ langConcat('Email_short Format') }}</label>
									{{ Form::select('email_format', ['html' => 'HTML', 'text' => lang('Text')], $user->getPreferenceItem('email_format'), ['class' => 'form-control']) }}
								</div>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>{{ langConcat('Site Preferences') }}</legend>

						<div class="row">
							<div class="col-md-8 col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ lang('Rank') }}</label>
									{{ Form::select('rank', RankCatalog::active()->get()->toSimpleArray('location', 'name'), $user->getPreferenceItem('rank'), ['class' => 'form-control', 'id' => 'rankSet']) }}
								</div>
							</div>
							<div class="col-md-4 col-lg-6">
								<label class="control-label">&nbsp;</label>
								<div id="rankImage"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ langConcat('Main Skin') }}</label>
									{{ Form::select('skin_main', SkinCatalog::active()->hasMain()->get()->toSimpleArray('location', 'name'), $user->getPreferenceItem('skin_main'), ['class' => 'form-control', 'id' => 'skinMain']) }}
								</div>
							</div>
							<div class="col-md-4 col-lg-6">
								<label class="control-label">&nbsp;</label>
								<div id="skinMainImage"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 col-lg-6">
								<div class="form-group">
									<label class="control-label">{{ langConcat('Admin Skin') }}</label>
									{{ Form::select('skin_admin', SkinCatalog::active()->hasAdmin()->get()->toSimpleArray('location', 'name'), $user->getPreferenceItem('skin_admin'), ['class' => 'form-control', 'id' => 'skinAdmin']) }}
								</div>
							</div>
							<div class="col-md-4 col-lg-6">
								<label class="control-label">&nbsp;</label>
								<div id="skinAdminImage"></div>
							</div>
						</div>
					</fieldset>

					<div class="row">
						<div class="col-lg-12">
							{{ Form::token() }}
							{{ Form::hidden('id') }}
							{{ Form::hidden('formAction', 'preferences') }}

							{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>

			<div id="emailNotifications" class="pill-pane">
				{{ Form::model($user, ['url' => "admin/user/edit/{$user->id}"]) }}
					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ lang('Comments') }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_comments', (int) true, $user->getPreferenceItem('email_comments')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_comments', (int) false, $user->getPreferenceItem('email_comments')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ lang('Messages') }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_messages', (int) true, $user->getPreferenceItem('email_messages')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_messages', (int) false, $user->getPreferenceItem('email_messages')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ ucwords(lang('personal_logs')) }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_logs', (int) true, $user->getPreferenceItem('email_logs')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_logs', (int) false, $user->getPreferenceItem('email_logs')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ lang('Announcements') }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_announcements', (int) true, $user->getPreferenceItem('email_announcements')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_announcements', (int) false, $user->getPreferenceItem('email_announcements')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ ucwords(lang('mission_posts')) }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_posts', (int) true, $user->getPreferenceItem('email_posts')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_posts', (int) false, $user->getPreferenceItem('email_posts')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ ucwords(langConcat('joint mission_posts action.saved')) }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_posts_save', (int) true, $user->getPreferenceItem('email_posts_save')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_posts_save', (int) false, $user->getPreferenceItem('email_posts_save')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-lg-6">
							<div class="form-group">
								<label class="control-label">{{ ucwords(langConcat('joint mission_posts action.deleted')) }}</label>
								<div>
									<label class="radio-inline">
										{{ Form::radio('email_posts_delete', (int) true, $user->getPreferenceItem('email_posts_delete')).' '.lang('Yes') }}
									</label>
									<label class="radio-inline">
										{{ Form::radio('email_posts_delete', (int) false, $user->getPreferenceItem('email_posts_delete')).' '.lang('No') }}
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							{{ Form::token() }}
							{{ Form::hidden('id') }}
							{{ Form::hidden('formAction', 'notifications') }}

							{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>

			@if ($_currentUser->hasLevel('user.update', 2))
				<div id="userAdmin" class="pill-pane"></div>
			@endif
		</div>
	</div>
</div>