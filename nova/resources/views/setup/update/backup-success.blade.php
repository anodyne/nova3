@extends('layouts.setup')

@section('title', 'Site Backup')

@section('header', 'Site Backup')

@section('content')
	<h1>Your Site Has Been Backed Up</h1>

	<p>We've successfully backed up your site and database!</p>

	<p>In the event you need to restore your site from that backup, you'll simply download the latest backup zip file from the <nobr><code>storage/app/backup</code></nobr> directory. After unzipping the contents to your desktop, you'll be able to upload the files and directories to your web server and import the SQL file into your database.</p>
@endsection

@section('controls')
	<a href="{{ route('setup.update.preRun') }}" class="btn btn-primary btn-lg">
		Next: Update {{ config('nova.app.name') }}
	</a>
	<a href="{{ route('setup.update') }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection