@props([
    'leading' => null,
    'notification',
    'actions' => null,
    'metadata' => null,
    'href' => null,
])

@php
    $date = Date::parse(data_get($notification, 'date'));
@endphp

<a role="button" wire:click.prevent="navigate('{{ data_get($notification, 'id') }}', '{{ $href }}')" class="group">
    <div class="relative flex gap-x-3 rounded-md py-3 leading-5 text-gray-500">
        @if ($href)
            <div
                class="absolute -inset-x-4 -inset-y-1 z-0 scale-95 bg-gray-50 opacity-0 transition group-hover:scale-100 group-hover:opacity-100 sm:rounded-xl dark:bg-gray-900"
            ></div>
        @endif

        <div
            @class([
                'relative z-10 size-7 shrink-0',
                $leading?->attributes?->get('class'),
            ])
            @style([
                $leading?->attributes?->get('style'),
            ])
        >
            {{ $leading }}
        </div>

        <div class="relative z-10 grow">
            <p
                class="leading-6 font-normal text-gray-600 dark:text-gray-400 [&_em]:font-medium [&_strong]:font-medium [&_strong]:text-gray-950 dark:[&_strong]:text-white"
            >
                {{ $slot }}
            </p>
            <p class="mt-2 text-sm text-gray-500">
                <time datetime="{{ $date->toAtomString() }}">{{ $date->diffForHumans() }}</time>
            </p>
        </div>

        <div
            @class([
                'relative z-10 block size-3 shrink-0 rounded-full group-hover:bg-transparent',
                'bg-primary-500' => data_get($notification, 'unread'),
            ])
        ></div>

        <div class="absolute -right-0.5 z-10 hidden group-hover:flex" @click.stop>
            <x-button.group>
                <x-button
                    type="button"
                    wire:click.stop.prevent="clearNotification('{{ data_get($notification, 'id') }}')"
                    data-danger
                    square
                >
                    <x-icon :name="Tabler::Trash" size="sm" />
                </x-button>

                @if (data_get($notification, 'unread'))
                    <x-button
                        type="button"
                        wire:click.stop.prevent="markNotificationAsRead('{{ data_get($notification, 'id') }}')"
                        square
                    >
                        <x-icon :name="Tabler::Check" size="sm" />
                    </x-button>
                @endif
            </x-button.group>
        </div>
    </div>
</a>
