@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<div {{ $attributes->merge(['class' => 'group relative flex items-center relative w-full rounded-md py-2 px-3 bg-gray-50 dark:bg-gray-700/50 focus-within:bg-white dark:focus-within:bg-gray-800 shadow-sm transition space-x-2 ring-1 ring-gray-200 dark:ring-gray-200/[15%] focus-within:ring-2 focus-within:ring-blue-400 dark:focus-within:ring-blue-400']) }}>
    @if ($leadingAddOn)
        <div class="flex items-center shrink-0 text-gray-400 dark:text-gray-500 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-300 sm:text-sm">
            {{ $leadingAddOn }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailingAddOn)
        <div class="flex items-center shrink-0 text-gray-400 hover:text-gray-500 sm:text-sm transition">
            {{ $trailingAddOn }}
        </div>
    @endif
</div>