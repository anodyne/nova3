@props(['header', 'footer'])

<div class="flex flex-col rounded-lg shadow-lg overflow-hidden" {{ $attributes }}>
    {{ $header ?? false }}

    <div class="flex-1 bg-white flex flex-col justify-between">
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