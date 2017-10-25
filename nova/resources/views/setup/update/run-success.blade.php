@extends('layouts.setup')

@section('title', 'Run Update')

@section('header', 'Run Update')

@section('content')
	<h1>Update Complete</h1>

	<p>We've finished running the update and your site has been updated to the latest version of {{ config('nova.app.name') }}.</p>
@endsection

@section('controls')
	<a href="{{ route('home') }}" class="btn btn-primary btn-lg">Next: Go to Your Site</a>
	<a href="{{ route('setup.update.changes') }}" class="btn btn-link-secondary btn-lg">
		Back: Summary of Changes
	</a>
@endsection