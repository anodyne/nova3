@props([
    'tag' => 'button',
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'md',
])

@php($tag = $attributes->has('href') ? 'a' : $tag)

<{{ $tag }}
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'inline-flex items-center justify-center gap-3 rounded-lg bg-gray-900 font-semibold text-white hover:bg-gray-700',
            match ($size) {
                'xs' => 'px-3 py-1.5 text-xs',
                'sm' => 'px-4 py-2.5 text-sm',
                default => 'px-4 py-2.5 text-base',
            },
            $attributes->get('class'),
        ])
    }}
>
    @if ($leading)
        <span class="shrink-0">
            <x-icon :name="$leading" :size="$size" class="opacity-80"></x-icon>
        </span>
    @endif

    <span class="w-full">{{ $slot }}</span>

    @if ($trailing)
        <span class="shrink-0">
            <x-icon :name="$trailing" :size="$size" class="opacity-80"></x-icon>
        </span>
    @endif
</{{ $tag }}>
