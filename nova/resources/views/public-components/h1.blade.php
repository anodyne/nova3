<h1
    {{ $attributes->merge(['class' => 'font-[family-name:--font-header] font-bold tracking-tight text-gray-900 @xs:text-4xl @md:text-6xl dark:text-white']) }}
>
    {{ $slot }}
</h1>
