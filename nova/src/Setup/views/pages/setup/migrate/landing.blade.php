@extends('layouts.setup')

@section('title')
	Migrate to {{ config('nova.app.name') }}
@stop

@section('header')
	Migrate to {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>Migrate to {{ config('nova.app.name') }}</h1>

	<p>{{ config('nova.app.name') }} is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the migration from Nova 2 should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the <a href='http://docs.anodyne-productions.com' target='_blank'>Anodyne Help Center</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<h2>Before You Begin</h2>

	<dl class="big-numbers">
		<dt>Help! How do I get my Nova 2 information over to {{ config('nova.app.name') }}???</dt>
		<dd>We've written an exhaustive <a href="#">migration guide</a> that will walk you through the process of moving from Nova 2 to {{ config('nova.app.name') }}. Make sure you've read through the guide in its entirety <strong>before</strong> attempting to migrate your site.</dd>

		<dt>Database Size Limits</dt>
		<dd>If your web host has limits set on the size of the database, you may not be able to migrate to {{ config('nova.app.name') }}. In order to preserve your original data, big portions of the database are duplicated so they can be converted. If there are size limits on your database, make sure the migration will not put you over those limits before you begin. If you aren't sure if there are size limits on your account, contact your web host.</dd>

		<dt>Backup. No seriously, back everything up. BACK. IT. UP.</dt>
		<dd>Last (but certainly not least), make sure you've backed up your Nova files and database before you get started. The migration process will attempt to do a backup for you, but the process may not be able to run if your server doesn't have the proper functions available.</dd>
		<dd>Files can be backed up by downloading them through your FTP client to a folder on your desktop. The database will have to be backed up by exporting the database tables in phpMyAdmin (likely reachable through your cPanel). If you have questions about how to do these things, check with your web host.</dd>
	</dl>

	<h2>Getting Help</h2>

	<p>The links below provide information about how to migrate to {{ config('nova.app.name') }} as well as a brief tour of some of {{ config('nova.app.name') }}'s major features. If you have additional questions, please visit the Anodyne Help Center or the Anodyne forums for more help.</p>

	<hr>

	<div class="row">
		<div class="col-sm-6 col-lg-3">
			<p><a href="http://help.anodyne-productions.com/article/nova-3/install-preview-release" target="_blank" class="btn btn-link btn-block">Migration Guide</a></p>
		</div>

		<div class="col-sm-6 col-lg-3">
			<p><a href="#" target="_blank" class="btn btn-link btn-block disabled">Take a Tour</a></p>
		</div>

		<div class="col-sm-6 col-lg-3">
			<p><a href="http://help.anodyne-productions.com/product/nova-3" target="_blank" class="btn btn-link btn-block">Anodyne Help Center</a></p>
		</div>

		<div class="col-sm-6 col-lg-3">
			<p><a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-link btn-block">Anodyne Forums</a></p>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.install.config.db') }}" class="btn btn-primary btn-lg">Next: Connect to Nova 2</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.home') }}" class="btn btn-link btn-lg">Cancel</a></p>
		</div>
	</div>
@stop