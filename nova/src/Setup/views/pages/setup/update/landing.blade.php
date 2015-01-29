@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Fresh Install
@stop

@section('content')
	<h1>Update</h1>

	<p>It isn't enough to just release powerful, easy-to-use software, it also needs to maintained. Our goal is to continually make {{ config('nova.app.name') }} better by fixing issues and adding new functionality. The best way to make sure you're getting the most out of {{ config('nova.app.name') }} is to keep up with any updates as they're released.</p>

	<blockquote>
		<h4>Before You Begin</h4>

		<p>We <strong>strongly</strong> recommend you backup both your files and your database before updating. We do our best to test the {{ config('nova.app.name') }} updates before releasing them, but there is only so much we can test for. In the end, it's better to be safe than sorry!</p>
	</blockquote>

	<hr class="partial">

	<div class="row">
		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Update Guide</a></p>
		</div>

		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Take a Tour</a></p>
		</div>

		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Anodyne Help Center</a></p>
		</div>

		<div class="col-md-3">
			<p><a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-link btn-block">Anodyne Forums</a></p>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6">
			<p><a href="{{ route('setup.home') }}" class="btn btn-link">Cancel</a></p>
		</div>
		<div class="col-md-6 text-right">
			<p>
				<a class="btn btn-link disabled">Let's Get Started!</a>
				<a href="{{ route('setup.install.config.db') }}" class="btn btn-primary">Next: Database Connection</a>
			</p>
		</div>
	</div>
@stop