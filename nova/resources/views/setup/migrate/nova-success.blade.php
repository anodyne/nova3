@extends('layouts.setup')

@section('title')
	Migrating to {{ config('nova.app.name') }}
@stop

@section('header')
	Migrating to {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>{{ config('nova.app.name') }} Migration Complete</h1>

	<p>{{ config('nova.app.name') }}'s database tables and data have been created for you and the information from your Nova 2 installation has been migrated into the new format. Next, you'll need to update a few things about user accounts in the system.</p>

	<h2>Migration Status</h2>

	<div class="data-table data-table-bordered data-table-striped">
		<div class="row">
			<div class="col-sm-1">
				@icon('nova/src/Setup/views/design/images/check', ['class' => 'table-icon text-success'])
			</div>
			<div class="col">
				<p><strong>Users</strong></p>
				<p class="text-muted">User accounts have been migrated into the {{ config('nova.app.name') }} format, including some user preferences. You will need to communicate the temporary password you set for users when you started the migration process in order for users to log in when the migration is complete.</p>
			</div>
		</div>
	</div>

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