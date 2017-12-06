@if ($sysinfo->migration_phase == 1)
	<div class="alert alert-info d-flex align-items-top" v-if="showMigrateChecklist">
		{!! icon('tasks', 'fa-3x mr-3') !!}
		<div>
			<h4 class="alert-title">Welcome to {{ config('nova.app.name') }} {{ config('nova.version') }}!</h4>

			<p>Congratulations on your migration of Nova 2 to <strong>{{ config('nova.app.name') }} {{ config('nova.version') }}</strong> and thank you for continuing to choose Nova for your game. We know it can be a little overwhelming when there are significant changes to something you're so used to, so we've put together a simple checklist of things you may want to consider doing before inviting your users to sign in and start using Nova.</p>

			<p>At the moment, sign-ins and the join form are disabled because you're in the first phase of migrating from Nova 2. Once you're satisified with your site's migration and are ready for your users to sign in, you can complete the migration process and both the sign in page and your join form will automatically be activated.</p>

			<p><strong>Note:</strong> When you click <em>I'm Finished</em>, an email will be sent to all of your active users announcing that the site is ready for them to sign in, provide instructions on finishing their account migration, and give them some information and links about what's new in {{ config('nova.app.name') }}.</p>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Verify that all of your data has been migrated properly</span>
				</label>
			</div>

			{{-- <div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" disabled>
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Update your site content</span>
				</label>
			</div> --}}

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Manage your site's <a href="{{ route('settings') }}" class="alert-link">settings</a></span>
				</label>
			</div>

			{{-- <div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" disabled>
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Customize your site with extensions &amp; themes from AnodyneXtras</span>
				</label>
			</div> --}}

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">
						<a href="#" class="alert-link" @click.prevent="sendTestEmail()">Send a test email</a> to confirm email settings
					</span>
				</label>
			</div>

			<div class="form-group mt-4">
				<a href="#"
				   class="btn btn-info btn-sm d-inline-flex align-items-center"
				   @click.prevent="finishMigration()">
					{!! icon('check', 'mr-2') !!}
					<span>I'm finished</span>
				</a>
			</div>
		</div>
	</div>
@endif