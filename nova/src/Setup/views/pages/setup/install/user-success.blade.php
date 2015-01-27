@extends('layouts.setup')

@section('title')
	Create User &amp; Character
@stop

@section('header')
	Create User &amp; Character
@stop

@section('content')
	<h1>User Account and Character Created</h1>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.install.nova') }}" class="btn btn-link">Back: Install {{ config('nova.app.name') }}</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p>
				<a class="btn btn-link disabled">Almost Done!</a>
				<a class="btn btn-primary">Next: Finalize</a>
			</p>
		</div>
	</div>
@stop