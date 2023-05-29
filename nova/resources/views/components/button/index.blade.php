@props([
    'tag' => 'button',
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'md',
])

@php($tag = $attributes->has('href') ? 'a' : $tag)

<{{ $tag }} {{ $attributes->merge([
    'type' => ($tag === 'button') ? $type : null,
])->class([
    'group inline-flex items-center text-center justify-center space-x-1.5 font-semibold transition cursor-pointer',
    'px-2.5 py-1 text-xs' => $size === 'xs',
    'px-2.5 py-1 text-sm' => $size === 'sm',
    'px-4 py-2.5 text-sm' => $size === 'md',
    'text-xs' => $size === 'none-xs',
    'text-sm' => $size === 'none',
    'text-base' => $size === 'none-base',
    $attributes->get('class'),
]) }}>
    @if ($leading)
        <span class="shrink-0">
            <x-icon :name="$leading" size="sm"></x-icon>
        </span>
        @endif

        <span>{{ $slot }}</span>

        @if ($trailing)
        <span class="shrink-0">
            <x-icon :name="$trailing" size="sm"></x-icon>
        </span>
    @endif
</{{ $tag }}>