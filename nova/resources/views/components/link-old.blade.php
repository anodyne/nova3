<a href="{{ $href }}" {{ $attributes->merge(['class' => $styles()]) }}>
    @if ($leading)
        <x-icon :name="$leading" size="sm"></x-icon>
    @endif

    <span>{{ $slot }}</span>

    @if ($trailing)
        <x-icon :name="$trailing" size="sm"></x-icon>
    @endif
</a>