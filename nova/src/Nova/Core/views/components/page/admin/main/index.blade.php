{{ d(Sentry::getUser()) }}

@foreach ($_icons as $key => $icon)
	<p><button class="btn icn16">{{ $icon }}</button> {{ $key }}</p>
@endforeach