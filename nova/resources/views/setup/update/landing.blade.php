@extends('layouts.setup')

@section('title')
	Update {{ config('nova.app.name') }}
@endsection

@section('header')
	Update {{ config('nova.app.name') }}
@endsection

@section('content')
	@if ($hasUpdate)
		<h1>Update to {{ config('nova.app.name') }} {{ $update->version }}</h1>

		<div class="row">
			<div class="col-sm-10 mx-auto">
				<p class="lead"><em>{{ $update->summary }}</em></p>
			</div>
		</div>

		<p>It isn't enough to just release powerful, easy-to-use software, it also needs to maintained. Our goal is to continually make {{ config('nova.app.name') }} better by fixing issues and adding new functionality. The best way to make sure you're getting the most out of {{ config('nova.app.name') }} is to keep up with any updates as they're released. The update process should only take a couple of minutes to complete and then you'll be back on your way. If you have questions, you can refer to the <a href='http://docs.anodyne-productions.com' target='_blank'>Anodyne Help Center</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

		<h2>Getting Help</h2>

		<p>The links below provide information about how to update to the latest version of {{ config('nova.app.name') }} as well as a brief tour of some of {{ config('nova.app.name') }}'s major features. If you have additional questions, please visit the Anodyne Help Center or the Anodyne forums for more help.</p>

		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<p><a href="http://help.anodyne-productions.com/article/nova-3/install-preview-release" target="_blank" class="btn btn-link btn-block">Update Guide</a></p>
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
	@else
		<h1>{{ config('nova.app.name') }} Is Up-to-Date!</h1>

		{!! alert('info', 'You have the latest version of '.config('nova.app.name').' installed.') !!}
	@endif
@endsection

@section('controls')
	@if ($hasUpdate)
		<a href="{{ route('setup.update.changes') }}" class="btn btn-primary btn-lg">Next: Summary of Changes</a>
	@endif
	<a href="{{ route('setup.home') }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection