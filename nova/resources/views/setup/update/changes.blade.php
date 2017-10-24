@extends('layouts.setup')

@section('title', 'Summary of Changes')

@section('header', 'Summary of Changes')

@section('content')
	<h1>Summary of Changes</h1>
	<h3>Here's what changed in {{ config('nova.app.name') }} since the last time you updated</h3>

	@foreach ($releases as $release)
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 col-lg-2">
						<h1 class="text-left">v{{ $release->version }}</h1>
						<small class="text-muted">{{ $release->prettyDate }}</small>
					</div>
					<div class="col-md-9 col-lg-10">
						{!! $release->notes !!}
					</div>
				</div>
			</div>
		</div>
	@endforeach
@endsection

@section('controls')
	<a href="{{ route('setup.update.preRun') }}" class="btn btn-primary btn-lg">
		Next: Update {{ config('nova.app.name') }}
	</a>
	<a href="{{ route('setup.update') }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection