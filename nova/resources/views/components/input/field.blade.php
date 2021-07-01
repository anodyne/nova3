@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<div {{ $attributes->merge(['class' => 'group flex items-center relative w-full rounded-md py-2 px-3 border border-gray-200 shadow-sm bg-white transition ease-in-out duration-200 space-x-2 focus-within:border-blue-7 focus-within:ring-1 focus-within:ring-blue-7']) }}>
    @if ($leadingAddOn)
        <div class="flex items-center flex-shrink-0 text-gray-400 group-focus-within:text-gray-500 | sm:text-sm">
            {{ $leadingAddOn }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailingAddOn)
        <div class="flex items-center flex-shrink-0 text-gray-400 group-focus-within:text-gray-500 | sm:text-sm">
            {{ $trailingAddOn }}
        </div>
    @endif
</div>
