@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Install Nova 3
@stop

@section('content')
	<h1>Install Nova 3</h1>

	<p>Nova 3 is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to <a href='http://docs.anodyne-productions.com' target='_blank'>AnodyneDocs</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<p>The links below provide information about how to install Nova 3 as well as a brief tour of some of Nova's major features. If you have additional questions, please visit AnodyneDocs or the Anodyne forums for more help.</p>

	<hr class="partial">

	<div class="row">
		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block">Nova 3 Install Guide</a></p>
		</div>

		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block">Take a Tour of Nova 3</a></p>
		</div>

		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block">Anodyne Help Center</a></p>
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
				<a href="{{ route('setup.install.config.db') }}" class="btn btn-primary">Next: Database</a>
			</p>
		</div>
	</div>
@stop