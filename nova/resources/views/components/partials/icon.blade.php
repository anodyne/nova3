@if ($type == "local")
	<span class="icn icn-size-{{ $size }} {{ $additional }}" data-icon="{{ $icon }}"></span>
@else
	<i class="material-icons {{ $size }} {{ $additional }}">{{ $icon }}</i>
@endif