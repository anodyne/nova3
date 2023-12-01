@props([
    'leading' => null,
    'notification',
    'actions' => null,
])

<div class="flex items-start gap-x-4">
    <div
        @class([
            'shrink-0',
            $leading?->attributes?->get('class'),
        ])
        @style([
            $leading?->attributes?->get('style'),
        ])
    >
        {{ $leading }}
    </div>

    <div class="w-full flex-1">
        <div>
            {{ $slot }}
        </div>

        <div class="mt-2">
            <x-text color="subtle" size="sm">
                {{ data_get($notification, 'date') }}
            </x-text>
        </div>

        @if ($actions?->isNotEmpty())
            <div class="mt-4 flex gap-x-4">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
