@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Setup Center
@stop

@section('content')
	<div class="row">
		<div class="col-md-4">
			<div class="thumbnail">
				@if ($db)
					<div class="icn icn-size-lg text-success" data-icon="k"></div>
				@else
					<div class="icn icn-size-lg text-error" data-icon="!"></div>
				@endif

				<h4>Database Connection</h4>

				@if ( ! $db and ! $email)
					<p><a href="{{ route('setup.config.db') }}" class="btn btn-primary btn-lg btn-block">Start</a></p>
				@else
					<p><a href="{{ route('setup.config.db') }}" class="btn btn-default btn-lg btn-block">Start Over</a></p>
				@endif
			</div>
		</div>

		<div class="col-md-4">
			<div class="thumbnail">
				@if ($email)
					<div class="icn icn-size-lg text-success" data-icon="k"></div>
				@else
					<div class="icn icn-size-lg text-error" data-icon="!"></div>
				@endif

				<h4>Email Settings</h4>

				@if ( ! $db and ! $email)
					<p><div class="btn btn-default btn-lg btn-block disabled">Start</div></p>
				@elseif ($db and ! $email)
					<p><a href="{{ route('setup.config.email') }}" class="btn btn-primary btn-lg btn-block">Start</a></p>
				@else
					<p><a href="{{ route('setup.config.email') }}" class="btn btn-default btn-lg btn-block">Start Over</a></p>
				@endif
			</div>
		</div>

		<div class="col-md-4">
			<div class="thumbnail">
				<div class="icn icn-size-lg text-muted" data-icon="!"></div>

				<h4>Install {{ config('nova.app.name')." ".config('nova.app.version.full') }}</h4>

				@if ($db and $email)
					<p><a href="{{ route('setup.start') }}" class="btn btn-primary btn-lg btn-block">Start</a></p>
				@else
					<p><div class="btn btn-default btn-lg btn-block disabled">Start</div></p>
				@endif
			</div>
		</div>
	</div>
@stop