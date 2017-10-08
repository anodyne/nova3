@extends('layouts.app')

@section('title', 'Settings')

@section('content')
	<h1>Settings</h1>

	<div class="row">
		<div class="col-md-4 col-lg-3">
			<div class="list-group bg-light">
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
				   :class="navClasses('manifest')"
				   @click.prevent="active = 'manifest'">
					{!! icon('users') !!} Manifest
				</a>
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
		</div>

		<div class="col">
			<fieldset v-show="active == 'info'">
				<legend>Basic Info</legend>
			</fieldset>

			<fieldset v-show="active == 'email'">
				<legend>Email</legend>
			</fieldset>

			<fieldset v-show="active == 'manifest'">
				<legend>Manifest</legend>

				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="form-control-label">Manifest Layout</label>

							<div>
								<div class="d-inline-flex">
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
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">Show Assigned Characters</label>
							<div>
								<toggle-button class="toggle-switch"
											   :value="{{ $settings['manifest_show_assigned'] }}"
											   @change="toggleSwitch('manifestShowAssigned')">
								</toggle-button>
								<input type="hidden" name="manifest_show_assigned" v-model="manifestShowAssigned">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">Show NPCs</label>
							<div>
								<toggle-button class="toggle-switch"
											   :value="{{ $settings['manifest_show_npcs'] }}"
											   @change="toggleSwitch('manifestShowNPCs')">
								</toggle-button>
								<input type="hidden" name="manifest_show_npcs" v-model="manifestShowNPCs">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">Show Inactive Characters</label>
							<div>
								<toggle-button class="toggle-switch"
											   :value="{{ $settings['manifest_show_inactive'] }}"
											   @change="toggleSwitch('manifestShowInactive')">
								</toggle-button>
								<input type="hidden" name="manifest_show_inactive" v-model="manifestShowInactive">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">Show Available Positions</label>
							<div>
								<toggle-button class="toggle-switch"
											   :value="{{ $settings['manifest_show_available'] }}"
											   @change="toggleSwitch('manifestShowAvailable')">
								</toggle-button>
								<input type="hidden" name="manifest_show_available" v-model="manifestShowAvailable">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<a href="#" class="btn btn-primary mt-4" @click.prevent="saveSettings">{{ _m('save') }}</a>
				</div>
			</fieldset>

			<fieldset v-show="active == 'themes'">
				<legend>Themes</legend>
			</fieldset>

			<fieldset v-show="active == 'extensions'">
				<legend>Extensions</legend>
			</fieldset>
		</div>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				active: 'manifest',
				manifestLayout: "{{ $settings['manifest_layout'] }}",
				manifestShowAssigned: {{ $settings['manifest_show_assigned'] }},
				manifestShowAvailable: {{ $settings['manifest_show_available'] }},
				manifestShowInactive: {{ $settings['manifest_show_inactive'] }},
				manifestShowNPCs: {{ $settings['manifest_show_npcs'] }}
			},

			methods: {
				navClasses (section) {
					let pieces = [
						'list-group-item',
						'list-group-item-action'
					];

					if (section == this.active) {
						pieces.push('active');
					}

					return pieces;
				},

				saveSettings () {
					let data = {
						'manifest_layout': this.manifestLayout,
						'manifest_show_assigned': this.manifestShowAssigned,
						'manifest_show_inactive': this.manifestShowInactive,
						'manifest_show_npcs': this.manifestShowNPCs,
						'manifest_show_available': this.manifestShowAvailable,
					};

					axios.patch(route('settings.update'), data)
						 .then(function (response) {
						 	flash('Site settings have been updated.', 'Settings updated');
						 })
						 .catch(function (error) {
						 	//
						 });
				},

				toggleSwitch (field) {
					this[field] = !this[field];
				}
			}
		};
	</script>
@endsection