@extends('layouts.setup')

@section('title', 'Verify Character Data')

@section('header', 'Verify Character Data')

@section('content')
	<h1>Characters Updated</h1>

	<p>Your characters updates have been applied.</p>
@endsection

@section('controls')
	<a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-primary btn-lg">
		Next: Update {{ config('nova.app.name') }} Settings
	</a>
	<a href="{{ route('setup.migrate.characters') }}" class="btn btn-link-secondary btn-lg">
		Back: Verify Character Data
	</a>
@endsection