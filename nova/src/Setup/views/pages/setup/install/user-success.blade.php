@extends('layouts.setup')

@section('title')
	Create User &amp; Character
@stop

@section('header')
	Create User &amp; Character
@stop

@section('content')
	<h1>User Account and Character Created</h1>

	<p>Your user account and primary character have been created and the {{ config('nova.app.name') }} installation is complete. You can go to your site now and start using {{ config('nova.app.name') }}.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p>&nbsp;</p>
		</div>
		<div class="col-md-6 text-right">
			<p><a href="{{ route('home') }}" class="btn btn-primary">Next: Go to Your Site</a></p>
		</div>
	</div>
@stop