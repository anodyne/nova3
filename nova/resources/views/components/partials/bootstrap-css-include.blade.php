@if (app('files')->exists(theme_path('design/css/bootstrap.css', false)))
	{!! HTML::style(theme_path('design/css/bootstrap.css')) !!}
@else
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
@endif