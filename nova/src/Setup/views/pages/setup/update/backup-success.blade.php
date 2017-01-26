@extends('layouts.setup')

@section('title')
	Site Backup
@stop

@section('header')
	Site Backup
@stop

@section('content')
	<h1>Your Site Has Been Backed Up</h1>

	{!! alert('danger', $errorMessage, 'Backup Error') !!}

	<p>We've successfully backed up your site and database!</p>

	<p>In the event you need to restore your site from that backup, you'll simply download the latest backup zip file from the <nobr><code>storage/app/backup</code></nobr> directory. After unzipping the contents to your desktop, you'll be able to upload the files and directories to your web server and import the SQL file into your database.</p>
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