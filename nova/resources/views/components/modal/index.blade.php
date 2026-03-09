@props([
    'footer' => null,
    'icon' => null,
    'color' => null,
    'description' => null,
    'title',
])

@php
    $color ??= 'gray';
@endphp

<x-panel variant="well" class="flex h-full flex-col" {{ $attributes }}>
    <x-panel class="flex-1">
        <x-spacing size="md">
            <div class="flex flex-col gap-6">
                <div class="flex justify-between gap-6">
                    <div class="flex flex-col gap-3">
                        @if ($icon)
                            <div class="inline-flex">
                                <div class="rounded-xl bg-white p-[3px] shadow-lg ring-1 ring-gray-950/15">
                                    <div
                                        @class([
                                            'rounded-[calc(theme(borderRadius.xl)-3px)] p-2 ring-1 ring-gray-950/10 ring-inset',
                                            match ($color) {
                                                'primary' => 'bg-primary-500',
                                                'danger' => 'bg-danger-500',
                                                'info' => 'bg-info-500',
                                                'success' => 'bg-success-500',
                                                'warning' => 'bg-warning-500',
                                                'gray' => 'bg-gray-800',
                                                default => $color,
                                            },
                                        ])
                                    >
                                        <x-icon
                                            :name="$icon"
                                            size="lg"
                                            @class([
                                                'text-gray-500' => $color === null,
                                                'text-white' => $color !== null,
                                            ])
                                        />
                                    </div>
                                </div>
                            </div>
                        @endif

                        <x-h2>{{ $title }}</x-h2>
                    </div>

                    <div class="shrink-0">
                        <button
                            x-on:click="Livewire.dispatch('modal.close')"
                            alt="Close modal"
                            class="relative inline-flex h-8 w-8 items-center justify-center gap-2 rounded-md bg-transparent text-sm font-medium whitespace-nowrap text-gray-400 transition hover:bg-gray-800/5 hover:text-gray-800 dark:text-gray-500 dark:hover:bg-white/15 dark:hover:text-white"
                        >
                            <x-icon :name="Tabler::X" size="sm" />
                        </button>
                    </div>
                </div>

                @if ($description)
                    <div class="text-base/7">{{ $description }}</div>
                @endif

                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </x-spacing>
    </x-panel>

    @if ($footer)
        <x-panel.footer class="flex items-center gap-x-4">
            {{ $footer }}
        </x-panel.footer>
    @endif
</x-panel>
