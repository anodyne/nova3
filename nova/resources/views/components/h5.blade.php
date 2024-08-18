<h4
    @class([
        'block font-[family-name:--font-header] text-sm font-medium text-gray-600 dark:text-gray-400',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</h4>
