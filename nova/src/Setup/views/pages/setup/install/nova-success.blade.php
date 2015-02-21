@extends('layouts.setup')

@section('title')
	Install {{ config('nova.app.name') }}
@stop

@section('header')
	Install {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>{{ config('nova.app.name') }} Installed</h1>

	<p>{{ config('nova.app.name') }}'s database tables and data have been created for you. Next, you'll need to create your user account and character.</p>

	{!! alert('warning', config('nova.app.name')." remains a work in progress. The database structure is nowhere near complete yet, so features and data you might be expecting will undoubtedly be missing at this stage. Future development work will flesh out those features and add much of that data. If you have questions, please don't hesitate to drop by the <a href='http://forums.anodyne-productions.com' class='alert-link' target='_blank'>Anodyne forums</a> and ask!", "Under Construction") !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 col-sm-push-6 text-right">
			<p><a href="{{ route('setup.install.user') }}" class="btn btn-primary btn-lg">Next: Create User &amp; Character</a></p>
		</div>
		<div class="col-sm-6 col-sm-pull-6">
			<p><a href="{{ route('setup.install.nova') }}" class="btn btn-link btn-lg">Back: Restart {{ config('nova.app.name') }} Install</a></p>
		</div>
	</div>
@stop