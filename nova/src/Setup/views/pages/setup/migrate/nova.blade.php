@extends('layouts.setup')

@section('title')
	Migrating to {{ config('nova.app.name') }}
@stop

@section('header')
	Migrating to {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>Migrating to {{ config('nova.app.name') }}</h1>

	<div v-show="loading">
		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div>

	<div v-show="loadingWithError" v-cloak>
		<div class="alert alert-danger">
			<h4 class="alert-heading">Error!</h4>
			<p>@{{ errorMessage }}</p>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Migrate User Accounts</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.migrate.config.email') }}" class="btn btn-link btn-lg">Back: Restart Email Settings</a></p>
		</div>
	</div>
@stop

@section('js')
	<script>
		app = {
			data: {
				loading: true,
				loadingWithError: false,
				errorMessage: ""
			},

			mounted: function () {
				this.$nextTick(function () {
					var url = "{{ url('setup/migrate/nova') }}"
					var self = this

					Vue.axios.post(url).then(function (response) {
						window.location = url + "/success"
					}).catch(function (error) {
						self.loading = false
						self.loadingWithError = true
						self.errorMessage = "Error " + error.response.status + ": " + error.message
					})
				})
			}
		}
	</script>
@stop