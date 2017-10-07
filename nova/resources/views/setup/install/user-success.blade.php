@extends('layouts.setup')

@section('title', 'Create User & Character')

@section('header', 'Create User & Character')

@section('content')
	<h1>User Account &amp; Character Created</h1>

	<p>Your user account and primary character have been created. As a final step, you'll be able to update some of the basic system settings to your liking.</p>
@endsection

@section('controls')
	<a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-primary btn-lg">Next: Update Settings</a>
@endsection