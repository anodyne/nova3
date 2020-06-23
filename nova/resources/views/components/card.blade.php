@props([
    'header' => false,
    'footer' => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col rounded-lg shadow-lg relative bg-white']) }}>
    @if ($header)
        {{ $header }}
    @endif

    <div class="flex-1 flex flex-col justify-between">
        <div class="flex-1 p-6">
            <div class="block">
                {{ $slot }}
            </div>
        </div>

        @if ($footer)
            <div class="px-4 py-3 | sm:px-6">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
