@extends('layouts.setup-landing')

@inject('setup', 'nova.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Setup Center
@stop

@section('content')
	@if ( ! $installed)
		<div class="row">
			<div class="col-md-6">
				<div class="thumbnail text-center">
					<h1>Fresh Install</h1>
					<div>{!! $setup->icon('new', 'xl') !!}</div>
					<p><a href="{{ route('setup.install') }}" class="btn btn-primary btn-lg btn-block">Install {{ config('nova.app.name') }}</a></p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="thumbnail text-center">
					<h1>Upgrade from Nova 2</h1>
					<div>{!! $setup->icon('migrate', 'xl') !!}</div>
					<p class="hide"><a href="#" class="btn btn-primary btn-lg btn-block disabled">Start Upgrade</a></p>
					<p><a href="#" class="btn btn-link btn-lg btn-block disabled">Not Available</a></p>
				</div>
			</div>
		</div>
	@else
		<div class="row">
			<div class="col-md-6">
				<div class="thumbnail text-center">
					<h1>Update {{ config('nova.app.name') }}</h1>
					<div>{!! $setup->icon('update', 'xl') !!}</div>
					<p class="hide"><a href="#" class="btn btn-primary btn-lg btn-block disabled">Start Update</a></p>
					<p><a href="#" class="btn btn-link btn-lg btn-block disabled">Not Available</a></p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="thumbnail text-center">
					<h1>Uninstall</h1>
					<div>{!! $setup->icon('trash', 'xl') !!}</div>
					{!! Form::open(['route' => 'setup.uninstall']) !!}
						<p>{!! Form::button('Remove '.config('nova.app.name'), ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	@endif
@stop