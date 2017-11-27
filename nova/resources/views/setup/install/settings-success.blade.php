@extends('layouts.setup')

@section('title', 'Update Settings')

@section('header', 'Update Settings')

@section('content')
	<h1>{{ config('nova.app.name') }} Settings Updated</h1>

	<p>Your {{ config('nova.app.name') }} settings have been updated and the {{ config('nova.app.name') }} installation is complete. You can go to your site now and start using {{ config('nova.app.name') }}.</p>
@stop

@section('controls')
	<a href="{{ route('home') }}" class="btn btn-primary btn-lg">Next: Go to Your Site</a>
	<a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-link-secondary btn-lg">
		Back: Update {{ config('nova.app.name') }} Settings
	</a>
@stop