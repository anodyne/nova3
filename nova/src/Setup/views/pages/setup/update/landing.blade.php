@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Update {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>Update {{ config('nova.app.name') }}</h1>

	<p>{{ config('nova.app.name') }} is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the <a href='http://docs.anodyne-productions.com' target='_blank'>Anodyne Help Center</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<h2>Before You Begin</h2>

	<h2>Getting Help</h2>

	<p>The links below provide information about how to install {{ config('nova.app.name') }} as well as a brief tour of some of {{ config('nova.app.name') }}'s major features. If you have additional questions, please visit the Anodyne Help Center or the Anodyne forums for more help.</p>

	<hr>

	<div class="row">
		<div class="col-sm-6 col-lg-3">
			<p><a href="http://help.anodyne-productions.com/article/nova-3/install-preview-release" target="_blank" class="btn btn-link btn-block">Update Guide</a></p>
		</div>

		<div class="col-sm-6 col-lg-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Take a Tour</a></p>
		</div>

		<div class="col-sm-6 col-lg-3">
			<p><a href="http://help.anodyne-productions.com/product/nova-3" target="_blank" class="btn btn-link btn-block">Anodyne Help Center</a></p>
		</div>

		<div class="col-sm-6 col-lg-3">
			<p><a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-link btn-block">Anodyne Forums</a></p>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.update.changes') }}" class="btn btn-primary btn-lg">Next: Summary of Changes</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.home') }}" class="btn btn-link btn-lg">Cancel</a></p>
		</div>
	</div>
@stop