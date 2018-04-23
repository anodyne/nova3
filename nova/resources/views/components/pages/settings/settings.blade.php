<h1>Settings</h1>

<div class="flex flex-row mt-4">
	<div class="w-1/4 mr-4">
		{{-- <a href="#"
		   :class="navClasses('info')"
		   @click.prevent="active = 'info'">
			{!! icon('info') !!} Basic Info
		</a>
		<a href="#"
		   :class="navClasses('email')"
		   @click.prevent="active = 'email'">
			{!! icon('email') !!} Email
		</a> --}}
		<a href="#"
		   class="w-full text-grey-dark flex items-start mb-6"
		   @click.prevent="active = 'info'">
		   	<icon name="info" :wrapper="{ class: 'p-1 bg-grey-light text-grey-dark rounded mr-2' }"></icon>
		   	<div class="flex flex-col">
				<span class="text-lg font-medium">Basic Info</span>
				<span class="text-grey text-sm">Basic settings for Nova</span>
			</div>
		</a>
		<a href="#"
		   class="w-full text-grey-dark flex items-start mb-6"
		   @click.prevent="active = 'email'">
		   	<icon name="email" :wrapper="{ class: 'p-1 bg-grey-light text-grey-dark rounded mr-2' }"></icon>
		   	<div class="flex flex-col">
				<span class="text-lg font-medium">Email</span>
				<span class="text-grey text-sm">Email settings for Nova</span>
			</div>
		</a>
		<a href="#"
		   class="w-full text-grey-dark flex items-start mb-6"
		   @click.prevent="active = 'manifest'">
		   	<icon name="users" :wrapper="{ class: 'p-1 bg-primary text-primary-lighter rounded mr-2' }"></icon>
		   	<div class="flex flex-col">
				<span class="text-lg font-medium">Manifest</span>
				<span class="text-grey text-sm">Manifest preferences</span>
			</div>
		</a>
		{{-- <a href="#"
		   class="w-full text-grey-dark flex items-start mb-6"
		   @click.prevent="active = 'themes'">
		   	<icon name="theme" :wrapper="{ class: 'p-1 bg-grey-light text-grey-dark rounded mr-2' }"></icon>
		   	<div class="flex flex-col">
				<span class="text-lg font-medium">Themes</span>
				<span class="text-grey text-sm">Pick a theme for Nova and customize its settings</span>
			</div>
		</a>
		<a href="#"
		   class="w-full text-grey-dark flex items-start mb-6"
		   @click.prevent="active = 'extensions'">
		   	<icon name="extension" :wrapper="{ class: 'p-1 bg-grey-light text-grey-dark rounded mr-2' }"></icon>
		   	<div class="flex flex-col">
				<span class="text-lg font-medium">Extensions</span>
				<span class="text-grey text-sm">Manage extensions for Nova</span>
			</div>
		</a> --}}
		{{-- <a href="#"
		   :class="navClasses('themes')"
		   @click.prevent="active = 'themes'">
			{!! icon('theme') !!} Themes
		</a>
		<a href="#"
		   :class="navClasses('extensions')"
		   @click.prevent="active = 'extensions'">
			{!! icon('extension') !!} Extensions
		</a> --}}
	</div>

	<div class="flex-1">
		<fieldset v-show="active == 'info'">
			<legend>Basic Info</legend>
		</fieldset>

		<fieldset v-show="active == 'email'">
			<legend>Email</legend>
		</fieldset>

		<div v-show="active == 'manifest'">
			<div class="form-title">Manifest</div>

			<div class="field-group">
				<label class="field-label">Manifest Layout</label>
				<div>
					<label class="custom-control custom-radio d-flex align-items-center">
						<input name="manifest_layout" type="radio" value="list" class="custom-control-input" v-model="manifestLayout">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description d-flex align-items-center">
							{!! icon('list', 'fa-lg fa-fw mr-2 text-muted') !!}
							<span>List</span>
						</span>
					</label>

					<label class="custom-control custom-radio d-flex align-items-center ml-3">
						<input name="manifest_layout" type="radio" value="cards" class="custom-control-input" v-model="manifestLayout">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description d-flex align-items-center">
							{!! icon('cards', 'fa-lg fa-fw mr-2 text-muted') !!}
							<span>Cards</span>
						</span>
					</label>
				</div>
			</div>

			<div class="row">
				<div class="col-12 md:col-6">
					<div class="field-group">
						<label class="field-label">Show Assigned Characters</label>
						<div class="field">
							<toggle-switch name="manifest_show_assigned" v-model="manifestShowAssigned" />
						</div>
					</div>
				</div>

				<div class="col-12 md:col-6">
					<div class="field-group">
						<label class="field-label">Show NPCs</label>
						<div class="field">
							<toggle-switch name="manifest_show_npcs" v-model="manifestShowNPCs" />
						</div>
					</div>
				</div>

				<div class="col-12 md:col-6">
					<div class="field-group">
						<label class="field-label">Show Inactive Characters</label>
						<div class="field">
							<toggle-switch name="manifest_show_inactive" v-model="manifestShowInactive" />
						</div>
					</div>
				</div>

				<div class="col-12 md:col-6">
					<div class="field-group">
						<label class="field-label">Show Available Positions</label>
						<div class="field">
							<toggle-switch name="manifest_show_available" v-model="manifestShowAvailable" />
						</div>
					</div>
				</div>
			</div>

			<div class="field-group">
				<a href="#" class="button is-primary" @click.prevent="saveSettings">{{ _m('save') }}</a>
			</div>
		</div>

		<fieldset v-show="active == 'themes'">
			<legend>Themes</legend>
		</fieldset>

		<fieldset v-show="active == 'extensions'">
			<legend>Extensions</legend>
		</fieldset>
	</div>
</div>