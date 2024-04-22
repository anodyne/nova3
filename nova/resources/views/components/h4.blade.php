<h4
    @class([
        'block font-[family-name:--font-header] text-base font-medium text-gray-700 dark:text-gray-300',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</h4>
