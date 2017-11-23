@if ($sysinfo->install_phase == 1 and $sysinfo->migration_phase == 0)
	<div class="alert alert-info d-flex align-items-top" v-if="showInstallChecklist">
		{!! icon('tasks', 'fa-3x mr-3') !!}
		<div>
			<h4 class="alert-title">Welcome to {{ config('nova.app.name') }}!</h4>

			<p>Congratulations on your fresh install of <strong>{{ config('nova.app.name') }} {{ config('nova.version') }}</strong>. From everyone at Anodyne, we want to thank you for choosing Nova to manage your game. We know it can be a little overwhelming to get started with a system like {{ config('nova.app.name') }}, so we've put together a simple checklist of things you may want to consider doing before inviting users to join your game.</p>

			<p>At the moment, the join form is disabled because you're in the first phase of installing {{ config('nova.app.name') }}. Once you're satisified with your site, you can complete the installation process by clicking <em>I'm Finished</em> below and your join form will be activated.</p>

			{{-- <div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" disabled>
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Update your site content (Coming Soon)</span>
				</label>
			</div> --}}

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Manage your site's <a href="{{ route('settings') }}" class="alert-link">settings</a></span>
				</label>
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Tailor <a href="{{ route('departments.index') }}" class="alert-link">departments</a> &amp; <a href="{{ route('positions.index') }}" class="alert-link">positions</a> to your game</span>
				</label>
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Setup <a href="{{ route('ranks.index') }}" class="alert-link">ranks</a> the way you want</span>
				</label>
			</div>

			{{-- <div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" disabled>
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Customize your site with extensions &amp; themes from AnodyneXtras (Coming Soon)</span>
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
				   @click.prevent="finishInstallation()">
					{!! icon('check', 'mr-2') !!}
					<span>I'm finished</span>
				</a>
			</div>
		</div>
	</div>
@endif