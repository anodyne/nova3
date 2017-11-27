@extends('layouts.setup')

@section('title', 'Configure Nova 2')

@section('header', 'Configure Nova 2')

@section('content')
	<h1>Nova 2 Configured</h1>

	<p>We've successfully connected to your Nova 2 instance and saved the connection details and options for the migration.</p>
@endsection

@section('controls')
	<a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-primary btn-lg">
		Next: Configure Database
	</a>
	<a href="{{ route('setup.'.$_setupType.'.config.nova2') }}" class="btn btn-link-secondary btn-lg">
		Back: Restart Nova 2 Configuration
	</a>
@endsection