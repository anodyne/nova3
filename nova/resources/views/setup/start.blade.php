@extends('layouts.setup-landing')

@section('title', 'Setup Center')

@section('header', 'Setup Center')

@section('content')
	@if (! $installed)
		<div class="row">
			<div class="col-md-6">
				<div class="card no-border text-center">
					<div class="card-topper-primary"></div>
					<div class="card-body">
						<h1>Fresh Install</h1>
						<div>
							@icon('setup/new-releases')
						</div>
						<p><a href="{{ route('setup.install') }}" class="btn btn-primary btn-lg btn-block">Install {{ config('nova.app.name') }}</a></p>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card no-border text-center">
					<div class="card-topper-warning"></div>
					<div class="card-body">
						<h1>Migrate from Nova 2</h1>
						<div>
							@icon('setup/exit-to-app')
						</div>
						<p><a href="{{ route('setup.migrate') }}" class="btn btn-primary btn-lg btn-block">Start Migration</a></p>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="row">
			<div class="{{ ($hasUpdate) ? 'col-md-12' : 'col-md-6' }} mx-auto">
				<div class="card text-center">
					<div class="card-topper-primary"></div>
					<div class="card-body">
						@if ($hasUpdate)
							<div class="row align-items-center">
								<div class="col-lg-6">
									<h1>Update to {{ config('nova.app.name') }} {{ $update->version }}</h1>
									<div>
										@icon('setup/cloud-upload')
									</div>
									<p><a href="{{ route('setup.update') }}" class="btn btn-primary btn-lg btn-block">Update {{ config('nova.app.name') }}</a></p>
								</div>
								<div class="col-lg-6">
									<p class="lead mt-4 mt-lg-0">{{ $update->summary }}</p>
								</div>
							</div>
						@else
							<h1>{{ config('nova.app.name') }} Is Up-To-Date</h1>
							<div>
								@icon('setup/cloud-done')
							</div>
							<p><a href="{{ route('home') }}" class="btn btn-primary btn-lg btn-block">Go to your site</a></p>
						@endif
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			methods: {
				uninstall (event) {
					swal({
						title: "Are you sure?",
						text: "Uninstalling Nova will remove all of your data and cannot be undone. If you want to keep your data, make sure to backup your files and database before continuing.",
						type: "error",
						showCancelButton: true,
						confirmButtonText: "Uninstall Now",
						confirmButtonClass: "btn btn-danger",
						cancelButtonClass: "btn btn-link-secondary",
						buttonsStyling: false
					}).then(function (confirmed) {
						if (confirmed) {
							event.target.submit();
						}
					}, function (dismiss) { });
				}
			}
		};
	</script>
@endsection