@extends('layouts.setup-landing')

@section('title', 'Setup Center')

@section('header', 'Setup Center')

@section('content')
	@if ( ! $installed)
		<div class="row">
			<div class="col-md-6">
				<div class="card text-center animate flipInX">
					<div class="card-block">
						<h1>Fresh Install</h1>
						<div>
							@icon('nova/src/Setup/views/design/images/new_releases')
						</div>
						<p><a href="{{ route('setup.install') }}" class="btn btn-primary btn-lg btn-block">Install {{ config('nova.app.name') }}</a></p>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card text-center animate flipInX">
					<div class="card-block">
						<h1>Migrate from Nova 2</h1>
						<div>
							@icon('nova/src/Setup/views/design/images/exit_to_app')
						</div>
						<p><a href="{{ route('setup.migrate') }}" class="btn btn-primary btn-lg btn-block">Start Migration</a></p>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="row">
			<div class="col-md-6">
				<div class="card text-center animate flipInX">
					<div class="card-block">
						@if ($hasUpdate)
							<h1>Update to {{ config('nova.app.name') }} {{ $update->version }}</h1>
							<div>
								@icon('nova/src/Setup/views/design/images/cloud_upload')
							</div>
							<p><a href="{{ route('setup.update') }}" class="btn btn-primary btn-lg btn-block">Update {{ config('nova.app.name') }}</a></p>
						@else
							<h1>{{ config('nova.app.name') }} Is Up-To-Date</h1>
							<div>
								@icon('nova/src/Setup/views/design/images/cloud_done')
							</div>
							<p><a href="{{ route('setup.update') }}" class="btn btn-link btn-lg btn-block disabled">No Updates Available</a></p>
						@endif
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card text-center animate flipInX">
					<div class="card-block">
						<h1>Uninstall</h1>
						<div>
							@icon('nova/src/Setup/views/design/images/delete')
						</div>
						{!! Form::open(['route' => 'setup.uninstall', '@submit.prevent' => 'uninstall', 'id' => 'uninstall']) !!}
							<p>{!! Form::button('Remove '.config('nova.app.name'), ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	@endif
@stop

@section('js')
	<script>
		app = {
			methods: {
				uninstall: function ($event) {
					swal({
						title: "Are you sure?",
						text: "Uninstalling Nova will remove all your data and cannot be undone. If you want to keep your data, make sure you have a backup of your files and database before continuing.",
						type: "warning",
						showCancelButton: true,
						confirmButtonText: "Uninstall Now",
						confirmButtonColor: "#ff6f00"
					}, function (confirmed) {
						if (confirmed) {
							document.getElementById("uninstall").submit()
						}
					})
				}
			}
		}
	</script>
@stop