@extends('layouts.setup')

@section('title', 'Update Settings')

@section('header', 'Update Settings')

@section('content')
	<h1>{{ config('nova.app.name') }} Settings Updated</h1>

	<p>Your {{ config('nova.app.name') }} settings have been updated and the {{ config('nova.app.name') }} first stage of the Nova 2 migration is complete. After signing in, we'll show you a checklist of things you may want to consider updating or changing before your players are notified that the new site is available to use.</p>

	<p>Visit your site and sign in now to continue the {{ config('nova.app.name') }} migration.</p>
@stop

@section('controls')
	<a href="{{ route('home') }}" class="btn btn-primary btn-lg">Next: Go to Your Site</a>
	<a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-link-secondary btn-lg">
		Back: Update {{ config('nova.app.name') }} Settings
	</a>
@stop