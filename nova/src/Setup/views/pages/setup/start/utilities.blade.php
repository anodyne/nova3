@extends('layouts.setup')

@section('title')
	Setup Center
@stop

@section('header')
	Nova Setup Utilities
@stop

@section('content')
	<div class="row">
		<div class="col-md-6">
			<h3><span class="icn icn-size-sm text-info" data-icon="u"></span> Update Nova</h3>

			<p>It isn't enough to just build Nova, it needs to be maintained too. Even if your server doesn't allow you to check for updates, you can start the update process from here and be up and running on the latest version of Nova in only a few minutes.</p>

			<a href="{{ url('setup/update') }}" class="btn btn-block">Update Nova</a>
		</div>

		<div class="col-md-6">
			<h3><span class="icn icn-size-sm text-error" data-icon="b"></span> Rollback Nova</h3>

			<p>There are situations where you may need or want to rollback to the previous version of Nova. While we work hard to make sure that doesn't need to happen, it is necessary sometimes. This process will <strong>attempt</strong> to roll your system back one version.</p>

			<a href="{{ url('setup/update/rollback') }}" class="btn btn-block">Rollback Nova</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<h3><span class="icn icn-size-sm text-warning" data-icon="g"></span> The Genre Panel</h3>

			<p>A flexible genre system allows Nova to be used for a wide range of games. Using the Genre Panel you can change your game's genre to one of the other provided genres. Changing the genre will require manual work to update your characters.</p>

			<a href="{{ url('setup/genres') }}" class="btn btn-block">The Genre Panel</a>
		</div>

		<div class="col-md-6">
			<h3><span class="icn icn-size-sm text-error" data-icon="-"></span> Uninstall Nova</h3>

			<p>If you want to completely uninstall Nova, you can do so with this option. <strong>Be warned:</strong> this action is permanent and cannot be undone. You will lose all data in the Nova database! Make sure you have backed everything up. Also note that this will not delete any Nova files.</p>

			<a href="{{ url('setup/uninstall') }}" class="btn btn-block">Uninstall Nova</a>
		</div>
	</div>
@stop

@section('controls')
	{!! HTML::link('/', 'Back to Site', ['class' => 'pull-right']) !!}
@stop