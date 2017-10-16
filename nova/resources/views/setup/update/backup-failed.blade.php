@extends('layouts.setup')

@section('title', 'Site Backup')

@section('header', 'Site Backup')

@section('content')
	<h1 class="text-danger">Backup Failed</h1>

	<div class="alert alert-danger">
		<h4 class="alert-heading">Backup Error</h4>
		<p>{!! $errorMessage !!}</p>
	</div>

	<p>You can proceed with the update without having a backup, but we <strong>strongly</strong> encourage you to create a manual backup of your files and database before continuing with the update process. While we strive to provide a painless and issue-free update process, there is always the potential that something will go awry during the update. <strong class="text-danger">Better safe than sorry!</strong></p>
@endsection

@section('controls')
	<a href="{{ route('setup.update.preRun') }}" class="btn btn-primary btn-lg">
		Next: Update {{ config('nova.app.name') }}
	</a>
	<a href="{{ route('setup.update') }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection