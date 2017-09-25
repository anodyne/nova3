@extends('layouts.setup')

@section('title')
	Install {{ config('nova.app.name') }}
@endsection

@section('header')
	Install {{ config('nova.app.name') }}
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-10 mx-auto">
			<h1>{{ config('nova.app.name') }} Installed</h1>

			<p>{{ config('nova.app.name') }}'s database tables and data have been created for you. Next, you'll need to create your user account and character.</p>

			<div class="alert alert-warning" role="alert">
				<h4 class="alert-heading">Please Excuse Our Dust...</h4>
				<p>{{ config('nova.app.name') }} remains a work in progress. The database structure is not yet complete, so features and data you might be expecting will undoubtedly be missing at this stage of development. Future work will flesh out those features and add much of that data. If you have questions, please don't hesitate to drop by the <a href="http://forums.anodyne-productions.com" class="alert-link" target="_blank">Anodyne forums</a> and ask!</p>
			</div>
		</div>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.install.user') }}" class="btn btn-primary btn-lg">Next: Create User &amp; Character</a>
	<a href="{{ route('setup.install.nova') }}" class="btn btn-link-secondary btn-lg">Back: Restart Install</a>
@endsection