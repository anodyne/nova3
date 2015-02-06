@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Fresh Install
@stop

@section('content')
	<h1>Fresh Install</h1>

	<p>{{ config('nova.app.name') }} is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the <a href='http://docs.anodyne-productions.com' target='_blank'>Anodyne Help Center</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<p>The links below provide information about how to install {{ config('nova.app.name') }} as well as a brief tour of some of {{ config('nova.app.name') }}'s major features. If you have additional questions, please visit the Anodyne Help Center or the Anodyne forums for more help.</p>

	<hr class="partial">

	<div class="row">
		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Install Guide</a></p>
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
			<p><a href="{{ route('setup.install.config.db') }}" class="btn btn-primary">Next: Database Connection</a></p>
		</div>
	</div>
@stop