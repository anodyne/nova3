@props([
    'icon' => null,
    'color' => null,
    'title',
    'action',
])

@php
    $color ??= $action->getModalIconColor() ?? $action->getColor();
    $icon ??= $action->getIcon();
@endphp

{{-- format-ignore-start --}}
<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-3">
        @if ($icon)
            <div class="inline-flex">
                <div class="p-[3px] rounded-xl bg-white ring-1 ring-gray-950/15 shadow-lg">
                    <div
                        @class([
                            'rounded-[calc(theme(borderRadius.xl)-3px)] p-2 ring-1 ring-inset ring-gray-950/10',
                            match ($color) {
                                'primary' => 'bg-primary-500',
                                'danger' => 'bg-danger-500',
                                'info' => 'bg-info-500',
                                'success' => 'bg-success-500',
                                'warning' => 'bg-warning-500',
                                'gray' => 'bg-gray-800',
                                default => $color,
                            }
                        ])
                    >
                        <x-icon :name="$icon" size="lg" @class([
                            'text-gray-500' => $color === null,
                            'text-white' => $color !== null,
                        ]) />
                    </div>
                </div>
            </div>
        @endif

        <x-h2>{{ $title }}</x-h2>
    </div>
    <div class="flex flex-col gap-4">
        {{ $slot }}
    </div>
</div>
{{-- format-ignore-end --}}
