@props(['header', 'footer'])

<div {{ $attributes->merge(['class' => 'flex flex-col rounded-lg shadow-lg overflow-hidden']) }}>
    {{ $header ?? false }}

    <div class="flex-1 bg-white dark:bg-gray-800 flex flex-col justify-between">
        <div class="flex-1 p-6">
            <div class="block">
                {{ $slot }}
            </div>
        </div>

        @if (isset($footer))
            <div class="px-4 py-3 | sm:px-6">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
