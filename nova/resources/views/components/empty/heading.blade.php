@aware(['variant'])

<h3
    data-slot="heading"
    @class([
        'text-center text-pretty text-gray-950 dark:text-white',
        'text-sm/6 font-medium' => $variant === 'compact',
        'text-base/7 font-semibold' => $variant !== 'compact',
    ])
>
    {{ $slot }}
</h3>
