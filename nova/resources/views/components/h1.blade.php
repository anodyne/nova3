<h1
    @class([
        'block font-[family-name:--font-header] text-4xl font-extrabold tracking-tight text-gray-900 sm:text-3xl dark:text-white',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</h1>
