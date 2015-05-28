@if (Auth::check())
	{!! alert('success', "You're logged in!") !!}
@endif