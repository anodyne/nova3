@extends('layouts.setup')

@section('title', 'Fresh Install')

@section('header', 'Fresh Install')

@section('content')
	<h1>Fresh Install</h1>

	<p>{{ config('nova.app.name') }} is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the <a href='http://docs.anodyne-productions.com' target='_blank'>Anodyne Help Center</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<h2>Before You Begin</h2>

	<dl class="big-numbers">
		<dt>Help! How do I install Nova???</dt>
		<dd>We've written an exhaustive <a href="#">install guide</a> that will walk you through the process of doing a fresh install of {{ config('nova.app.name') }}. Make sure you've read through the guide in its entirety <strong>before</strong> attempting to run the installer.</dd>

		<dt>The Database</dt>
		<dd>During the installation, you'll be prompted for your database connection information (the host, username, password, port, etc.). You should have gotten an email from your web host with this information. <strong>Make sure you have this information ready to go before you start!</strong> If you don't have the information or have questions about how to connect to your database, contact your web host.</dd>

		<dt>Email</dt>
		<dd>{{ config('nova.app.name') }} sends a wide array of emails and as such, one of the steps involves setting up how you want email to behave. In the past, we've relied on PHP's built-in email features, but over the years, that's gotten more and more unreliable with many admins reporting that email stops working randomly. To avoid these issues, we <strong>strongly recommend</strong> using a third-party SMTP service. We've assembled <a href="#">some information</a> about SMTP services and which ones we recommend.</dd>
	</dl>

	<h2>Getting Help</h2>

	<p>The links below provide information about how to install {{ config('nova.app.name') }} as well as a brief tour of some of {{ config('nova.app.name') }}'s major features. If you have additional questions, please visit the Anodyne Help Center or the Anodyne forums for more help.</p>

	<div class="row">
		<div class="col-sm-6 col-lg-3">
			<p><a href="http://help.anodyne-productions.com/article/nova-3/install-preview-release" target="_blank" class="btn btn-link btn-block">Install Guide</a></p>
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
@endsection

@section('controls')
	<a href="{{ route('setup.install.config.db') }}" class="btn btn-primary btn-lg">Next: Database Connection</a>
	<a href="{{ route('setup.home') }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection