@extends('layouts.setup')

@section('title', 'Nova 2 Connection')

@section('header', 'Nova 2 Connection')

@section('content')
	<h1>Nova 2 Connection Configured</h1>

	<p>We've successfully connected to your Nova 2 instance and saved the connection details for the migration.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.'.$_setupType.'.config.db') }}" class="btn btn-primary btn-lg">Next: Configure Database</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.'.$_setupType.'.config.nova2') }}" class="btn btn-link btn-lg">Back: Restart Nova 2 Connection</a></p>
		</div>
	</div>
@stop