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

		<div class="row" v-show="!loading">
			<div class="col-md-4 col-lg-3 col-xl-2 offset-md-2 offset-lg-3 offset-xl-4">
				<p><a role="button" href="#" class="btn btn-outline-primary btn-block" @click.prevent="runBackup">Backup Now</a></p>
			</div>
			<div class="col-md-4 col-lg-3 col-xl-2">
				<p><a href="{{ route('setup.update.preRun') }}" class="btn btn-outline-secondary btn-block">Skip Backup</a></p>
			</div>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.update.backup') }}" class="btn btn-link btn-lg disabled">Next: Update {{ config('nova.app.name') }}</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.update.changes') }}" class="btn btn-link btn-lg">Back: Summary of Changes</a></p>
		</div>
	</div>
@stop

@section('js')
	<script>
		app = {
			data: {
				loading: false
			},

			methods: {
				runBackup: function () {
					var url = "{{ url('setup/update/backup') }}"

					this.loading = true
					var self = this

					Vue.axios.post(url).then(function (response) {
						window.location = url + "/success"
					}).catch(function (error) {
						window.location = url + "/failed"
					})
				}
			}
		}
	</script>
@stop