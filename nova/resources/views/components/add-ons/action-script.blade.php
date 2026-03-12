@props([
    'action',
    'icon',
    'title',
    'color' => 'gray',
    'alert' => null,
    'warning' => null,
    'info' => null,
])

<div class="space-y-4">
    <div class="relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex items-center justify-between">
            <div class="flex items-center">
                <div
                    @class([
                        'rounded-lg p-1 ring-1 ring-inset',
                        match ($color) {
                            'primary' => 'bg-primary-50 text-primary-700 ring-primary-200 dark:bg-primary-950 dark:text-primary-300 dark:ring-primary-800',
                            'warning' => 'bg-warning-50 text-warning-700 ring-warning-200 dark:bg-warning-950 dark:text-warning-300 dark:ring-warning-800',
                            'danger' => 'bg-danger-50 text-danger-700 ring-danger-200 dark:bg-danger-950 dark:text-danger-300 dark:ring-danger-800',
                            'success' => 'bg-success-50 text-success-700 ring-success-200 dark:bg-success-950 dark:text-success-300 dark:ring-success-800',
                            'info' => 'bg-info-50 text-info-700 ring-info-200 dark:bg-info-950 dark:text-info-300 dark:ring-info-800',
                            default => 'bg-gray-50 text-gray-700 ring-gray-200 dark:bg-gray-950 dark:text-gray-300 dark:ring-gray-800',
                        },
                    ])
                >
                    <x-icon :name="$icon" size="sm" />
                </div>
                <span class="bg-white px-3 text-sm/6 font-semibold text-gray-900">{{ $title }}</span>
            </div>

            {{ $action }}
        </div>
    </div>

    <div class="ml-10 space-y-4 pr-4">
        <x-text>
            {{ $slot }}
        </x-text>

        @if (filled($warning))
            <x-text color="warning">
                <strong>Warning:</strong>
                {{ $warning }}
            </x-text>
        @endif

        @if (filled($info))
            <x-text color="info">
                {{ $info }}
            </x-text>
        @endif

        @if (filled($alert))
            <x-text color="danger">
                <strong>Danger:</strong>
                {{ $alert }}
            </x-text>
        @endif
    </div>
</div>
