@extends('layouts.setup')

@section('title')
	Migrating to {{ config('nova.app.name') }}
@endsection

@section('header')
	Migrating to {{ config('nova.app.name') }}
@endsection

@section('content')
	<h1>Migrating to {{ config('nova.app.name') }}</h1>

	<div class="row" v-cloak>
		<div class="col-lg-8 col-xl-7 mx-auto">
			<div class="data-table bordered striped">
				<div class="row" v-for="migration in migrations">
					<div class="col d-flex align-items-center justify-content-start">
						<label class="custom-control custom-checkbox">
							<input type="checkbox"
								   class="custom-control-input"
								   :disabled="migration.required"
								   v-model="migration.active">
							<span class="custom-control-indicator"></span>
						</label>
						<div class="d-flex flex-column">
							<p class="lead mb-0">@{{ migration.label }}</p>
							<small class="text-danger" v-if="migration.status == 'failed'">@{{ migration.message }}</small>
							<small class="text-muted" v-if="migration.status == 'skipped'">@{{ migration.message }}</small>
						</div>
						<div class="ml-auto">
							<div v-show="migration.running">
								<i class="fa fa-spinner-third fa-spin fa-lg fa-fw text-muted"></i>
							</div>
							<div v-show="!migration.running">
								<i class="fa fa-check fa-lg fa-fw text-success" v-if="migration.status == 'success'"></i>
								<i class="fa fa-exclamation-triangle fa-lg fa-fw text-danger" v-if="migration.status == 'failed'"></i>
								<i class="fa fa-exclamation-circle fa-lg fa-fw text-muted" v-if="migration.status == 'skipped'"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-lg-3 col-xl-2 offset-md-2 offset-lg-3 offset-xl-4">
			<p>
				<a role="button"
				   href="#"
				   :class="migrateButton"
				   @click.prevent="runAllMigrations()">
					<span v-show="!active">Migrate</span>
					<span v-show="active">
						<i class="fa fa-spinner-third fa-spin fa-lg fa-fw"></i>
					</span>
				</a>
			</p>
		</div>
		<div class="col-md-4 col-lg-3 col-xl-2">
			<p><a href="{{ route('setup.migrate') }}" class="btn btn-outline-secondary btn-block">Cancel</a></p>
		</div>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.migrate.characters') }}" :class="nextButton">
		Next: Verify Character Data
	</a>
	<a href="{{ route('setup.migrate.config.email') }}" class="btn btn-link-secondary btn-lg">
		Back: Restart Email Settings
	</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				migrations: [
					{ key: 'install', label: 'Install Nova', required: true, status: null, running: false, active: true },
					{ key: 'genres', label: 'Departments & Positions', required: true, status: null, running: false, active: true },
					{ key: 'users', label: 'Users', required: true, status: null, running: false, active: true },
					{ key: 'characters', label: 'Characters', required: true, status: null, running: false, active: true }
				],
				active: false,
				migrationsComplete: false
			},

			computed: {
				migrateButton () {
					if (this.active) {
						return ['btn', 'btn-outline-primary', 'btn-block', 'disabled'];
					}

					return ['btn', 'btn-outline-primary', 'btn-block'];
				},

				nextButton () {
					if (this.migrationsComplete) {
						return ['btn', 'btn-primary', 'btn-lg'];
					}

					return ['btn', 'btn-primary', 'btn-lg', 'disabled'];
				}
			},

			methods: {
				runAllMigrations () {
					this.active = true;
					this.migrationsComplete = false;

					let self = this;

					// Get all of the migrations that are active
					let migrations = this.migrations.filter(function (m) {
						return m.active;
					});

					// Remove the first option (which should always be the installer)
					let install = migrations.splice(0, 1)[0];

					// Kick everything off with the installer
					let result = this.runSingleMigration(install);

					// Loop through all of the remaining migrations
					migrations.forEach(function (m) {
						// Run the next migration after the previous one is resolved
						result = result.then(function () {
							return self.runSingleMigration(m);
						});
					});

					result.then(function () {
						self.active = false;
						self.migrationsComplete = true;
					});
				},

				runSingleMigration (migrator) {
					migrator.running = true;

					return axios.post(route('setup.migrate.run-single', {key:migrator.key}))
						.then(function (response) {
							migrator.running = false;
							migrator.status = response.data.status;
							migrator.message = response.data.message;
						}).catch(function (error) {
							migrator.running = false;
							migrator.status = 'failed';
							migrator.message = error.response.statusText;
						});
				}
			}
		};
	</script>
@endsection