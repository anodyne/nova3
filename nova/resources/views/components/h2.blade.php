<h2
    data-slot="heading"
    @class([
        'block font-[family-name:--font-header] text-xl font-bold tracking-tight text-gray-900 dark:text-white',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</h2>
