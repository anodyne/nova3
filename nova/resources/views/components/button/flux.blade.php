@props([
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'base',
    'outline' => false,
    'plain' => false,
    'text' => false,
    'variant' => null,
])

@use('Illuminate\Support\Arr')

@php
    $tag = $attributes->has('href') ? 'a' : 'button';

    // $variant = $outline ? 'outline' : ($plain ? 'plain' : ($text ? 'text' : 'solid'));

    $size = $text ? 'none' : $size;

    $variant = ($variant === 'primary' && settings('appearance.panda')) ? 'panda' : $variant;
@endphp

<{{ $tag }}
    data-slot="button"
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 text-sm font-medium group-[]/button:-ml-[1px] group-[]/button:first:ml-0',

            // Disabled state
            'disabled:pointer-events-none disabled:cursor-default disabled:opacity-50 dark:disabled:opacity-75',

            match ($variant) {
                'danger' => 'bg-danger-500 text-white shadow-[inset_0px_1px_theme(colors.danger.500),inset_0px_2px_theme(colors.white/.15)] hover:bg-danger-600 group-[]/button:border-black dark:bg-danger-600 dark:shadow-none dark:hover:bg-danger-500 group-[]/button:dark:border-zinc-900/25',

                'filled' => '',

                'ghost' => '',

                'primary' => 'bg-gray-800 text-white shadow-[inset_0px_1px_theme(colors.gray.900),inset_0px_2px_theme(colors.white/.15)] hover:bg-gray-900 group-[]/button:border-black dark:bg-white dark:text-gray-800 dark:shadow-none dark:hover:bg-gray-100 group-[]/button:dark:border-gray-900/25',

                default => 'border border-gray-200 border-b-gray-300/80 bg-white text-gray-800 shadow-sm hover:border-gray-200 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-600/75',
            },
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
