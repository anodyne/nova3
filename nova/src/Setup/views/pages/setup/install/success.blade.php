@extends('layouts.setup')

@section('title')
	Install {{ config('nova.app.name') }}
@stop

@section('header')
	Install {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>{{ config('nova.app.name') }} Installed</h1>

	<p>{{ config('nova.app.name') }}'s database tables and data have been created for you. Next, you'll need to create your user account and character.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.install.config.email') }}" class="btn btn-link">Back: Email Settings</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p><a class="btn btn-primary">Next: Create User</a></p>
		</div>
	</div>
@stop