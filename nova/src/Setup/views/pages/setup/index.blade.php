@extends('layouts.setup-landing')

@section('title')
	Setup Center
@stop

@section('header')
	Setup Center
@stop

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="thumbnail text-center">
				<h1>Fresh Install</h1>
				<div>{!! icon($_icons['new'], 'xlg') !!}</div>
				<p><a href="{{ route('setup.install') }}" class="btn btn-primary btn-lg btn-block">Install {{ config('nova.app.name') }}</a></p>
			</div>
		</div>

		<div class="col-md-6">
			<div class="thumbnail text-center">
				<h1>Upgrade from Nova 2</h1>
				<div>{!! icon($_icons['update'], 'xlg') !!}</div>
				<p><a href="{{ route('setup.config.email') }}" class="btn btn-primary btn-lg btn-block">Start Upgrade</a></p>
			</div>
		</div>
	</div>
@stop