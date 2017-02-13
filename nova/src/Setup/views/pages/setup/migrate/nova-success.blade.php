@extends('layouts.setup')

@section('title')
	Migrating to {{ config('nova.app.name') }}
@stop

@section('header')
	Migrating to {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>{{ config('nova.app.name') }} Migration Complete</h1>

	<p>{{ config('nova.app.name') }}'s database tables and data have been created for you. Next, you'll need to create your user account and character.</p>

	{!! alert('warning', config('nova.app.name')." remains a work in progress. The database structure is not yet complete, so features and data you might be expecting will undoubtedly be missing at this stage of development. Future work will flesh out those features and add much of that data. If you have questions, please don't hesitate to drop by the <a href='http://forums.anodyne-productions.com' class='alert-link' target='_blank'>Anodyne forums</a> and ask!", "Please Excuse Our Dust...") !!}
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.migrate.accounts') }}" class="btn btn-primary btn-lg">Next: Migrate User Accounts</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.migrate.nova') }}" class="btn btn-link btn-lg">Back: Restart Install</a></p>
		</div>
	</div>
@stop