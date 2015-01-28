@extends('layouts.setup-landing')

@section('title')
	Environment Checks
@stop

@section('header')
	Environment Checks
@stop

@section('content')
	@if ($env->get('php'))
		<div class="row">
			<div class="col-md-12">
				<div class="thumbnail text-center">
					<h1>Writable Directories</h1>
					<h2>Are all the necessary directories writable for {{ config('nova.app.name') }}?</h2>

					@if ($env->get('writableDirs'))
						<div>{!! icon($_icons['checkmark'], 'xlg', 'text-success') !!}</div>
					@else
						<div>{!! icon($_icons['warning'], 'xlg', 'text-danger') !!}</div>
						<p>In order to work properly, {{ config('nova.app.name') }} needs permissions to write to several directories on your server for error logging, route caching, and a few other things. Some of these directories aren't writable at the moment. In order to fix this, you'll need to make sure these directories have permissions of <code>777</code>. If you're not sure what that means, get in touch with your web host and they'll be able to help you resolve this issue.</p>

						<p>At the moment, the follow directories need to have their permissions updated:</p>

						<ul class="list-unstyled">
							@foreach ($env->get('writableDirsFull') as $dir)
								<li><code>{{ $dir }}</code></li>
							@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			<div class="thumbnail text-center">
				<h1>PHP</h1>
				<h2>Version 5.4+</h2>

				@if ($env->get('php'))
					<div>{!! icon($_icons['checkmark'], 'xlg', 'text-success') !!}</div>
				@else
					<div>{!! icon($_icons['warning'], 'xlg', 'text-danger') !!}</div>
					<p>Uh oh! It looks like your server isn't running a high enough version of PHP. In order to use {{ config('nova.app.name') }}, your server needs to be running at least PHP 5.4. Your server is currently running <strong class="text-danger">{{ PHP_VERSION }}</strong>. Sometimes, web hosts run multiple versions of PHP and it's possible to switch your account over to a different PHP version. Get in touch with your web host and see if this is something they can resolve for you.</p>
				@endif
			</div>
		</div>
	</div>
@stop