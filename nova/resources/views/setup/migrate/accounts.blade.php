@extends('layouts.setup')

@section('title', 'Migrate User Accounts')

@section('header', 'Migrate User Accounts')

@section('content')
	<h1>Migrate User Accounts</h1>

	<h2>Set Access Levels</h2>

	<div class="row">
		<div class="col-sm-6"></div>

		<div class="col-sm-6"></div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Update Settings</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.migrate.nova') }}" class="btn btn-link btn-lg">Back: Restart Migration</a></p>
		</div>
	</div>
@stop