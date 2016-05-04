@extends('layouts.setup')

@section('title')
	Install {{ config('nova.app.name') }}
@stop

@section('header')
	Install {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>Install {{ config('nova.app.name') }}</h1>

	<div v-show="loading">
		<p class="text-center"><img src="{{ asset('nova/src/Setup/views/design/images/ajax-loader.gif') }}"></p>
	</div>
	<div v-show="loadingWithError" v-cloak>
		<div class="alert alert-danger">
			<h4 class="alert-title">Error!</h4>
			<p>@{{ errorMessage }}</p>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 col-sm-push-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Create User &amp; Character</a></p>
		</div>
		<div class="col-sm-6 col-sm-pull-6">
			<p><a href="{{ route('setup.install.config.email') }}" class="btn btn-link btn-lg">Back: Restart Email Settings</a></p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		var vm = new Vue({
			el: "#app",

			data: {
				loading: true,
				loadingWithError: false,
				errorMessage: ""
			},

			http: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			},

			ready: function () {
				var url = "{{ url('setup/install/nova') }}"

				this.$http.post(url).then(response => {
					window.location = "{{ url('setup/install/nova/success') }}"
				}, response => {
					this.loading = false
					this.loadingWithError = true

					if (response.status == 404) {
						this.errorMessage = "The installer could not be found!"
					} else {
						this.errorMessage = "Error " + response.status + ": " + response.statusText
					}
				})
			}
		})
	</script>
@stop