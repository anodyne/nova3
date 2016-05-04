@if (Session::has('flash_message'))
	@php

	$level = Session::get('flash_message.level');
	$level = ($level == 'error') ? 'danger' : $level;
	$content = Session::get('flash_message.message');
	$title = Session::get('flash_message.title');

	@endphp
@endif

{!! alert($level, $content, $title) !!}