@extends('layouts.setup')

@section('title')
	Summary of Changes
@stop

@section('header')
	Summary of Changes
@stop

@section('content')
	<h1>Summary of Changes</h1>
	<h3>Here's what changed in {{ config('nova.app.name') }} since the last time you updated</h3>

	@foreach ($releases as $release)
		<div class="card">
			<div class="card-block">
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
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.update.backup') }}" class="btn btn-primary btn-lg">Next: Site Backup</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.update') }}" class="btn btn-link btn-lg">Cancel</a></p>
		</div>
	</div>
@stop