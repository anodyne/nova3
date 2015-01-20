@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Nova Setup
@stop

@section('content')
	@if ($option == 1)
		
	@elseif ($option == 2)
		<p>Nova 3 is a dynamic, database-driven web system which means, you guessed it, I need to install the Nova-specific database pieces now and then migrate most of your Nova data to the newer Nova 3 format. Start to finish, the migration should only take a few minutes to complete (depending on your Internet connection and how much data you have) and then you'll be on your way.</p>

		<blockquote>
			<h4>A Few Notes Before Starting</h4>

			<p>If your host has imposed limits on the size of your database, you may not be able to upgrade to Nova 3. In order to preserve your original data, big portions of the database are duplicated. If you have size limits on your database, please make sure the upgrade will not put your over those limits before you begin.</p>

			<p>We've written an exhaustive <a href="#">upgrade guide</a> that walks you through the process of moving from Nova 2 to 3. Make sure you've read through that document in its entirety before attempting to upgrade your game.</p>

			<p>Last (but certainly not least), make sure you've backed up your Nova files and database before you get started. Files can be backed up by downloading through your FTP client to a folder on your desktop. The database will have to be backed up by exporting the database tables in phpMyAdmin (likely reachable through your cPanel). If you have questions about how to do these things, check with your host.</p>
		</blockquote>

		<div class="row">
			<div class="col-lg-4">
				<a href="#" target="_blank" class="btn btn-block">Nova 2 &rarr; Nova 3 Upgrade Guide</a>
			</div>

			<div class="col-lg-4">
				<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
			</div>

			<div class="col-lg-4">
				<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
			</div>
		</div>
	@elseif ($option == 3)
		<p>It isn't enough to just release powerful, easy-to-use software, it also needs to maintained. Our goal is to continually make Nova better by fixing issues and adding new functionality. The best way to make sure you're getting the most out of Nova is to keep up with any updates as they're released.</p>

		<blockquote>
			<h4>Before You Begin</h4>

			<p>We <strong>strongly</strong> recommend that you backup both your files and your database. We do our best to test the Nova updates before releasing them, but there is only so much we can test for. In the end, it's better to be safe rather than sorry.</p>
		</blockquote>

		<div class="row">
			<div class="col-lg-4">
				<a href="#" target="_blank" class="btn btn-block">Nova 3 Update Guide</a>
			</div>

			<div class="col-lg-4">
				<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
			</div>

			<div class="col-lg-4">
				<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
			</div>
		</div>
		
		<hr>
		
		<h2>{{ $update['version'] }}</h2>
		
		<p>{{ $update['description'] }}</p>
	@elseif ($option == 4)
		
	@elseif ($option == 5)
		<p>It looks like you're running Nova 1 right now. Unfortunately, there's no way to migrate directly from Nova 1 to Nova 3. In order to get up and running (with most of your Nova 1 data) on Nova 3, you'll need to first update from Nova 1 to Nova 2. Once you're done with that (you don't need to worry about MOD/skin updates) you'll be able to migrate from Nova 2 to Nova 3.</p>

		<div class="row">
			<div class="col-lg-4">
				<a href="#" target="_blank" class="btn btn-block">Nova 1 &rarr; Nova 3 Upgrade Guide</a>
			</div>

			<div class="col-lg-4">
				<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
			</div>

			<div class="col-lg-4">
				<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
			</div>
		</div>
	@endif
@stop