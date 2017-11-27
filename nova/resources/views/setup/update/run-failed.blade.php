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
	<a class="btn btn-primary btn-lg disabled">Next: Go to Your Site</a>
	<a href="{{ route('setup.update.changes') }}" class="btn btn-link-secondary btn-lg">
		Back: Summary of Changes
	</a>
@endsection