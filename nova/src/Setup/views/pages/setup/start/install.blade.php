@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Install Nova 3
@stop

@section('content')
	<p>Nova 3 is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to <a href='http://docs.anodyne-productions.com' target='_blank'>AnodyneDocs</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<p>The links below provide information about how to install Nova 3 as well as a brief tour of some of Nova's major features. If you have additional questions, please visit AnodyneDocs or the Anodyne forums for more help.</p>

	<div class="row">
		<div class="col-md-3">
			<a href="#" target="_blank" class="btn btn-block">Nova 3 Install Guide</a>
		</div>

		<div class="col-md-3">
			<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
		</div>

		<div class="col-md-3">
			<a href="#" target="_blank" class="btn btn-block">AnodyneDocs</a>
		</div>

		<div class="col-md-3">
			<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
		</div>
	</div>
@stop

@section('controls')
	{!! Form::open(['url' => 'setup/install']) !!}
		{!! Form::button('Start Install', [ 'class' => 'btn btn-primary', 'id' => 'next', 'name' => 'submit', 'type' => 'submit']) !!}
	{!! Form::close() !!}
@stop

@section('steps')
	{!! view('partials.steps-install') !!}
@stop