@extends('layouts.setup')

@section('title')
	Create User &amp; Character
@stop

@section('header')
	Create User &amp; Character
@stop

@section('content')
	<h1>User Account &amp; Character Created</h1>

	<p>Your user account and primary character have been created. As a final step, you'll be able to update some of the basic system settings to your liking.</p>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-primary btn-lg">Next: Update Settings</a></p>
		</div>
		<div class="col-md-6 pull-md-6 hidden-sm-down">
			<p>&nbsp;</p>
		</div>
	</div>
@stop