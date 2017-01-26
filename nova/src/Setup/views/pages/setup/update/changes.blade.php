@extends('layouts.setup')

@section('title')
	Summary of Changes
@stop

@section('header')
	Summary of Changes
@stop

@section('content')
	<h1>Summary of Changes</h1>
	<h3>Here's what changed in {{ config('nova.app.name') }} since the last time you updated</h3>

	<div class="card">
		<div class="card-block">
			<div class="row">
				<div class="col-md-3 col-lg-2">
					<h1 class="text-left">v3.1</h1>
				</div>
				<div class="col-md-9 col-lg-10">
					<ul>
						<li>Created a new <code>Mail</code> wrapper class around SwiftMailer for better email handling than CodeIgniter's built-in email class. Thanks to forum user TheDrew for helping us sort through some of these issues.</li>
					</ul>

					<h2>Nova Core</h2>

					<ul>
						<li>Updated the controllers with the new Mail class calls.</li>
						<li>We've removed all the reply-to calls with emails since more and more spam filters are checking the reply-to headers as well as the from header.</li>
						<li>Added a notice to the bottom of all emails that it's an automated email and they shouldn't reply to the message.</li>
						<li>Updated the manifest Javascript to remove hard-coded calls to a table structure. This has become problematic as people have begun to modify the manifest to have less traditional layouts.</li>
						<li>Updated the error language file with a new error message.</li>
					</ul>

					<h2>Fixed Issues</h2>

					<ul>
						<li>When there is no manifest metadata, an extra space is displayed.</li>
						<li>Fixed issue where users could view pending and saved mission posts, personal logs, and news items from their respective view pages.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-block">
			<div class="row">
				<div class="col-md-3 col-lg-2">
					<h1 class="text-left">v3.0.7</h1>
				</div>
				<div class="col-md-9 col-lg-10">
					<h2>Nova Core</h2>

					<ul>
						<li>Updated the Nova database to allow for mission posts, personal logs, and news items of more than 65,000 characters.</li>
						<li>Updated the behavior of replying to a private message from your own sent messages. Previously, it would reply to yourself, but now will reply to the original recipient. (Thanks to Williams for this update!)</li>
						<li>Updated how Nova handles incrementing the version number in hopes of mitigating the "0.0.0" database version issue.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-block">
			<div class="row">
				<div class="col-md-3 col-lg-2">
					<h1 class="text-left">v3.0.6</h1>
				</div>
				<div class="col-md-9 col-lg-10">
					<h2>Nova Core</h2>

					<ul>
						<li>We've updated the gender identification selections on new installations to be more in line with social conventions. Hermaphrodite has been replaced with Transgendered/Intersex and Neuter has been replaced with Agendered/Non-Binary.</li>
					</ul>

					<h2>Fixed Issues</h2>

					<ul>
						<li>We've made some changes to the email class in the hopes of reducing the number of errors people are starting to see.</li>
						<li>Addressed an error with assigning departments to a manifest.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@stop

@section('controls')
	<div class="row">
		<div class="col-md-6 push-md-6 text-right">
			<p><a href="{{ route('setup.update.backup') }}" class="btn btn-primary btn-lg">Next: Site Backup</a></p>
		</div>
		<div class="col-md-6 pull-md-6">
			<p><a href="{{ route('setup.update') }}" class="btn btn-link btn-lg">Cancel</a></p>
		</div>
	</div>
@stop