@extends('layouts.setup-landing')

@section('title', 'Setup Center')

@section('header', 'Setup Center')

@section('content')
	@if (! $installed)
		<div class="block my-4">
    <div class="inline-flex items-center bg-blue-lightest px-2 py-1 rounded border border-blue-lighter leading-normal">
      <div class="text-sm text-blue font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-sm bg-blue text-white uppercase tracking-wide text-2xs font-semibold p-1 leading-none">City</div>
    </div>

    <div class="inline-flex items-center bg-blue-lightest pl-3 pr-2 py-1 rounded-full border border-blue-lighter leading-normal">
      <div class="text-sm text-blue font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-full bg-blue text-white uppercase tracking-wide text-2xs font-semibold px-2 py-1 leading-none">City</div>
    </div>
  </div>

  <div class="block my-4">
    <div class="inline-flex items-center bg-purple-lightest px-2 py-1 rounded border border-purple-lighter leading-normal">
      <div class="text-sm text-purple font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-sm bg-purple text-white uppercase tracking-wide text-2xs font-semibold p-1 leading-none">City</div>
    </div>

    <div class="inline-flex items-center bg-purple-lightest pl-3 pr-2 py-1 rounded-full border border-purple-lighter leading-normal">
      <div class="text-sm text-purple font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-full bg-purple text-white uppercase tracking-wide text-2xs font-semibold px-2 py-1 leading-none">City</div>
    </div>
  </div>

  <div class="block my-4">
    <div class="inline-flex items-center bg-green-lightest px-2 py-1 rounded border border-green-lighter leading-normal">
      <div class="text-sm text-green font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-sm bg-green text-white uppercase tracking-wide text-2xs font-semibold p-1 leading-none">City</div>
    </div>

    <div class="inline-flex items-center bg-green-lightest pl-3 pr-2 py-1 rounded-full border border-green-lighter leading-normal">
      <div class="text-sm text-green font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-full bg-green text-white uppercase tracking-wide text-2xs font-semibold px-2 py-1 leading-none">City</div>
    </div>
  </div>

  <div class="block my-4">
    <div class="inline-flex items-center bg-red-lightest px-2 py-1 rounded border border-red-lighter leading-normal">
      <div class="text-sm text-red font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-sm bg-red text-white uppercase tracking-wide text-2xs font-semibold p-1 leading-none">City</div>
    </div>

    <div class="inline-flex items-center bg-red-lightest pl-3 pr-2 py-1 rounded-full border border-red-lighter leading-normal">
      <div class="text-sm text-red font-semibold mr-2 leading-none">Liverpool</div>
      <div class="rounded-full bg-red text-white uppercase tracking-wide text-2xs font-semibold px-2 py-1 leading-none">City</div>
    </div>
  </div>

		<div class="mb-12 bg-white rounded p-6 overflow-hidden shadow-md">
			<div class="font-title text-3xl text-center mb-6">
				Choose...
			</div>

			<div class="row">
				<div class="col-12 md:col-4 md:col-offset-2">
					<div class="w-full rounded border-2 border-blue-lighter p-3">
						<div class="text-center mb-6">
							<div class="inline-flex rounded-full bg-blue-lightest p-4">
								@icon('setup/new-releases', ['class' => 'h-12 w-12 text-blue'])
							</div>
						</div>
						<div class="text-center">
							<div class="font-title text-2xl">Fresh Install</div>
							<div class="mt-3 text-grey-dark text-lg">Start with a new installation of {{ config('nova.app.name') }} for your game.</div>

							{{-- <a href="#" class="py-3 px-6 bg-blue rounded text-white font-semibold text-lg">Start Install</a> --}}
						</div>
					</div>
				</div>

				<div class="col-12 md:col-4">
					<div class="w-full rounded border-2 border-transparent p-3">
						<div class="text-center mb-6">
							<div class="inline-flex rounded-full bg-blue-lightest p-4">
								@icon('setup/new-releases', ['class' => 'h-12 w-12 text-blue'])
							</div>
						</div>
						<div class="text-center">
							<div class="font-title text-2xl">Fresh Install</div>
							<div class="mt-3 text-grey-dark text-lg">Start with a new installation of {{ config('nova.app.name') }} for your game.</div>

							{{-- <a href="#" class="py-3 px-6 bg-blue rounded text-white font-semibold text-lg">Start Install</a> --}}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12 md:col-6">
				<div class="w-full rounded bg-white shadow-md overflow-hidden p-6">
					<div class="text-center mb-6">
						<div class="inline-flex rounded-full bg-blue-lightest p-4">
							@icon('setup/new-releases', ['class' => 'h-12 w-12 text-blue'])
						</div>
					</div>
					<div class="text-center">
						<div class="font-title text-2xl">Fresh Install</div>
						<div class="mt-3 text-grey-dark text-lg">Start with a new installation of {{ config('nova.app.name') }} for your game.</div>

						{{-- <a href="#" class="py-3 px-6 bg-blue rounded text-white font-semibold text-lg">Start Install</a> --}}
					</div>
				</div>

				{{-- <div class="card no-border text-center">
					<div class="card-topper-primary"></div>
					<div class="card-body">
						<h1>Fresh Install</h1>
						<div>
							@icon('setup/new-releases')
						</div>
						<p><a href="{{ route('setup.install') }}" class="btn btn-primary btn-lg btn-block">Install {{ config('nova.app.name') }}</a></p>
					</div>
				</div> --}}
			</div>

			<div class="col-12 md:col-6">
				<div class="w-full rounded bg-white shadow-md overflow-hidden p-6">
					<div class="text-center mb-6">
						<div class="inline-flex rounded-full bg-blue-lightest p-4">
							@icon('setup/exit-to-app', ['class' => 'h-12 w-12 text-blue'])
						</div>
					</div>
					<div class="text-center">
						<div class="font-title text-2xl">Migrate from Nova 2</div>
						<div class="mt-3 text-grey-dark text-lg">Move your data from your old Nova 2 game over to {{ config('nova.app.name') }}.</div>

						{{-- <a href="#" class="py-3 px-6 bg-blue rounded text-white font-semibold text-lg">Start Install</a> --}}
					</div>
				</div>

				{{-- <div class="card no-border text-center">
					<div class="card-topper-warning"></div>
					<div class="card-body">
						<h1>Migrate from Nova 2</h1>
						<div>
							@icon('setup/exit-to-app')
						</div>
						<p><a href="{{ route('setup.migrate') }}" class="btn btn-primary btn-lg btn-block">Start Migration</a></p>
					</div>
				</div> --}}
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
