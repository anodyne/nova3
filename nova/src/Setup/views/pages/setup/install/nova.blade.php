@extends('layouts.setup')

@section('title')
	Install {{ config('nova.app.name') }}
@stop

@section('header')
	Install {{ config('nova.app.name') }}
@stop

@section('content')
	<h1>Install {{ config('nova.app.name') }}</h1>

	<p class="text-center"><img src="{{ asset('nova/src/Setup/views/design/images/ajax-loader.gif') }}"></p>
@stop

@section('controls')
	<div class="row">
		<div class="col-sm-6 col-sm-push-6 text-right">
			<p><a class="btn btn-link btn-lg disabled">Next: Create User &amp; Character</a></p>
		</div>
		<div class="col-sm-6 col-sm-pull-6">
			<p><a href="{{ route('setup.install.config.email') }}" class="btn btn-link btn-lg">Back: Restart Email Settings</a></p>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$(document).ready(function()
		{
			$.ajax({
				type: "POST",
				url: "{{ url('setup/install/nova') }}",
				data: {
					"_token": "{{ csrf_token() }}"
				},
				success: function(data)
				{
					window.location = "{{ url('setup/install/nova/success') }}"
				}
			});
		});
	</script>
@stop