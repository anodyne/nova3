@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<div {{ $attributes->merge(['class' => 'flex items-center relative w-full rounded-md py-2 px-3 border border-gray-200 shadow-sm bg-white transition ease-in-out duration-200 space-x-2 focus-within:border-blue-300 focus-within:shadow-outline-blue']) }}>
    @if ($leadingAddOn)
        <div class="flex items-center flex-shrink-0 text-gray-500 | sm:text-sm">
            {{ $leadingAddOn }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailingAddOn)
        <div class="flex items-center flex-shrink-0 text-gray-500 | sm:text-sm">
            {{ $trailingAddOn }}
        </div>
    @endif
</div>
