@extends('layouts.setup')

@section('title', 'Site Backup')

@section('header', 'Site Backup')

@section('content')
	<h1>Backup Your Site</h1>
	<h3>Let's make sure you have a recent backup of your site before updating</h3>

	<div v-cloak>
		<div v-show="loading">
			<div class="spinner">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>

		<div class="d-flex justify-content-around" v-show="!loading">
			<div>
				<a role="button" href="#" class="btn btn-outline-primary mr-2" @click.prevent="runBackup">
					Backup Now
				</a>
				<a href="{{ route('setup.update.preRun') }}" class="btn btn-outline-secondary ml-2">
					Skip Backup
				</a>
			</div>
		</div>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.update.backup') }}" class="btn btn-primary btn-lg disabled">
		Next: Update {{ config('nova.app.name') }}
	</a>
	<a href="{{ route('setup.update.changes') }}" class="btn btn-link-secondary btn-lg">
		Back: Summary of Changes
	</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				loading: false
			},

			methods: {
				runBackup () {
					this.loading = true;
					var self = this;

					axios.post(route('setup.update.backup.run'))
						.then(function (response) {
							//window.location = url + "/success"
						}).catch(function (error) {
							//window.location = url + "/failed"
						});
				}
			}
		};
	</script>
@endsection