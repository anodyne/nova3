@extends('layouts.setup')

@section('title', 'Run Update')

@section('header', 'Run Update')

@section('content')
	<h1 class="text-danger">Update Failed</h1>

	<div class="alert alert-danger">
		<h4 class="alert-heading">Update Error</h4>
		<p>{!! $errorMessage !!}</p>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.update.preRun') }}" class="btn btn-primary btn-lg">
		Next: Update {{ config('nova.app.name') }}
	</a>
	<a href="{{ route('setup.update') }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection