@extends('layouts.setup')

@section('title', 'Site Backup')

@section('header', 'Site Backup')

@section('content')
	<h1 class="text-danger">Backup Failed</h1>

	{!! alert('danger', $errorMessage, 'Backup Error') !!}

	<p>You can proceed with the update without having a backup, but we <strong>strongly</strong> encourage you to create a manual backup of your files and database before continuing with the update process. While we strive to provide a painless and issue-free update process, there is always the potential that something will go awry during the update. <strong class="text-danger">Better safe than sorry!</strong></p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.update.preRun') }}" class="btn btn-primary btn-lg">Next: Update {{ config('nova.app.name') }}</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.update') }}" class="btn btn-link btn-lg">Cancel</a></p>
		</div>
	</div>
@stop