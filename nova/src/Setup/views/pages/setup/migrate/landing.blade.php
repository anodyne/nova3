@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Fresh Install
@stop

@section('content')
	<h1>Fresh Install</h1>

	<p>{{ config('nova.app.name') }} is a dynamic, database-driven web system which means, you guessed it, I need to install the Nova-specific database pieces now and then migrate most of your Nova 2 data to the newer {{ config('nova.app.name') }} format. Start to finish, the migration should only take a few minutes to complete (depending on your Internet connection and how much data you have) and then you'll be on your way.</p>

	<blockquote>
		<h4>A Few Notes Before Starting</h4>

		<p>If your host has imposed limits on the size of your database, you may not be able to upgrade to {{ config('nova.app.name') }}. In order to preserve your original data, big portions of the database are duplicated. If you have size limits on your database, please make sure the upgrade will not put your over those limits before you begin.</p>

		<p>We've written an exhaustive <a href="#">upgrade guide</a> that walks you through the process of moving from Nova 2 to 3. Make sure you've read through that document in its entirety before attempting to upgrade your game.</p>

		<p>Last (but certainly not least), make sure you've backed up your Nova files and database before you get started. Files can be backed up by downloading through your FTP client to a folder on your desktop. The database will have to be backed up by exporting the database tables in phpMyAdmin (likely reachable through your cPanel). If you have questions about how to do these things, check with your host.</p>
	</blockquote>

	<hr class="partial">

	<div class="row">
		<div class="col-md-3">
			<a href="#" target="_blank" class="btn btn-link btn-block disabled">Nova 2 &rarr; {{ config('nova.app.name') }} Upgrade Guide</a>
		</div>

		<div class="col-md-3">
			<a href="#" target="_blank" class="btn btn-link btn-block disabled">Take a Tour</a>
		</div>

		<div class="col-md-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Anodyne Help Center</a></p>
		</div>

		<div class="col-md-3">
			<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-link btn-block">Anodyne Forums</a>
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
				<a href="{{ route('setup.install.config.db') }}" class="btn btn-primary">Next: Database Connection</a>
			</p>
		</div>
	</div>
@stop