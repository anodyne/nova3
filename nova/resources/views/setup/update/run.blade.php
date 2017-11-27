@extends('layouts.setup')

@section('title', 'Run Update')

@section('header', 'Run Update')

@section('content')
	<h1>Run the Update</h1>

	<div class="row">
		<div class="col-sm-10 offset-sm-1">
			<p class="lead"><em>{{ $update->summary }}</em></p>
		</div>
	</div>

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
				<p><a role="button" href="#" class="btn btn-outline-primary btn-block" @click.prevent="runUpdate">Run Update</a></p>
			</div>
			<div class="col-md-4 col-lg-3 col-xl-2">
				<p><a href="{{ route('home') }}" class="btn btn-outline-secondary btn-block">Cancel Update</a></p>
			</div>
		</div>
	</div>
@stop

@section('controls')
	<a class="btn btn-primary btn-lg disabled">Next: Go to Your Site</a>
	<a href="{{ route('setup.update.changes') }}" class="btn btn-link-secondary btn-lg">
		Back: Summary of Changes
	</a>
@stop

@section('js')
	<script>
		vue = {
			data: {
				loading: false
			},

			methods: {
				runUpdate () {
					let url = route('setup.update.run');

					this.loading = true;
					let self = this;

					axios.post(url).then(function (response) {
						window.location = route('setup.update.success');
					}).catch(function (error) {
						console.log(error);
						window.location = route('setup.update.failed');
					});
				}
			}
		};
	</script>
@stop