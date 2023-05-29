<button {{ $attributes->merge(['type' => 'button', 'class' => $styles()]) }}>
    @if ($leading)
        <x-icon :name="$leading" size="sm"></x-icon>
    @endif

    <span>{{ $slot }}</span>

    @if ($trailing)
        <x-icon :name="$trailing" size="sm"></x-icon>
    @endif
</button>