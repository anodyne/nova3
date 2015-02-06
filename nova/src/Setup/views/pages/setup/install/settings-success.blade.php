@extends('layouts.setup')

@section('title')
	Update Settings
@stop

@section('header')
	Update Settings
@stop

@section('content')
	<h1>{{ config('nova.app.name') }} Settings Updated</h1>

	<p>Your {{ config('nova.app.name') }} settings have been updated and the {{ config('nova.app.name') }} installation is complete. You can go to your site now and start using {{ config('nova.app.name') }}.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-link btn-lg">Back: Update {{ config('nova.app.name') }} Settings</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p><a href="{{ route('home') }}" class="btn btn-primary btn-lg">Next: Go to Your Site</a></p>
		</div>
	</div>
@stop