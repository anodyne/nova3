@extends('layouts.setup')

@section('title')
	Installing {{ config('nova.app.name') }}
@endsection

@section('header')
	Installing {{ config('nova.app.name') }}
@endsection

@section('content')
	<h1>Installing {{ config('nova.app.name') }}</h1>

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
@endsection

@section('controls')
	<a class="btn btn-primary btn-lg disabled">Next: Create User &amp; Character</a>
	<a href="{{ route('setup.install.config.email') }}" class="btn btn-link-secondary btn-lg">
		Back: Restart Email Settings
	</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				loading: true,
				loadingWithError: false,
				errorMessage: ""
			},

			mounted () {
				this.$nextTick(function () {
					let url = "{{ url('setup/install/nova') }}";
					let self = this;

					axios.post(url).then(function (response) {
						window.location = url + "/success"
					}).catch(function (error) {
						self.loading = false
						self.loadingWithError = true
						self.errorMessage = "Error " + error.response.status + ": " + error.message
					});
				})
			}
		};
	</script>
@endsection