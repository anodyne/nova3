<h2
    {{ $attributes->merge(['class' => 'font-[family-name:--font-header] font-bold tracking-tight text-gray-900 @xs:text-3xl @md:text-4xl dark:text-white']) }}
>
    {{ $slot }}
</h2>
