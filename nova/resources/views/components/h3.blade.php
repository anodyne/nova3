<h3
    @class([
        'block font-[family-name:--font-header] text-lg font-semibold text-gray-700 dark:text-gray-300',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</h3>
