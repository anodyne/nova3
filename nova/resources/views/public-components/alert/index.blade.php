@props([
    'level' => null,
    'title' => null,
    'body' => null,
])

<div
    {{
        $attributes->class([
            'nova-alert rounded-lg p-4 ring-1 ring-inset',
            match ($level) {
                'danger' => 'nova-alert-danger bg-danger-50 ring-danger-100',
                'info' => 'nova-alert-info bg-info-50 ring-info-100',
                'primary' => 'nova-alert-primary bg-primary-50 ring-primary-100',
                'success' => 'nova-alert-success bg-success-50 ring-success-100',
                'warning' => 'nova-alert-warning bg-warning-50 ring-warning-100',
                default => 'bg-gray-50 ring-gray-100',
            },
        ])
    }}
>
    <div class="flex gap-x-3">
        @if (in_array($level, ['danger', 'info', 'success', 'warning']))
            <div
                @class([
                    'shrink-0',
                    '[&>[data-slot=icon]]:size-5',
                    match ($level) {
                        'danger' => 'text-danger-400',
                        'info' => 'text-info-400',
                        'primary' => 'text-primary-400',
                        'success' => 'text-success-400',
                        'warning' => 'text-warning-400',
                        default => 'text-gray-400',
                    },
                ])
            >
                @if ($level === 'danger')
                    <x-icon.micro.alert></x-icon.micro.alert>
                @endif

                @if ($level === 'info')
                    <x-icon.micro.info></x-icon.micro.info>
                @endif

                @if ($level === 'success')
                    <x-icon.micro.check></x-icon.micro.check>
                @endif

                @if ($level === 'warning')
                    <x-icon.micro.warning></x-icon.micro.warning>
                @endif
            </div>
        @endif

        @if (filled($title) || filled($slot))
            <div>
                @if (filled($title))
                    <h3
                        @class([
                            'font-[family-name:--font-header] text-sm font-semibold',
                            match ($level) {
                                'danger' => 'text-danger-800',
                                'info' => 'text-info-800',
                                'primary' => 'text-primary-800',
                                'success' => 'text-success-800',
                                'warning' => 'text-warning-800',
                                default => 'text-gray-800',
                            },
                        ])
                    >
                        {{ $title }}
                    </h3>
                @endif

                @if (filled($slot))
                    <div
                        @class([
                            'mt-2 font-[family-name:--font-body] text-sm',
                            match ($level) {
                                'danger' => 'text-danger-700',
                                'info' => 'text-info-700',
                                'primary' => 'text-primary-700',
                                'success' => 'text-success-700',
                                'warning' => 'text-warning-700',
                                default => 'text-gray-700',
                            },
                        ])
                    >
                        <p>
                            {{ $slot }}
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
