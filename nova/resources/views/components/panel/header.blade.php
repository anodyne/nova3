@props([
    'title',
    'message' => false,
    'actions' => null,
    'border' => true,
])

<div
    @class([
        'border-b border-gray-200 dark:border-gray-800' => $border
    ])
>
    <x-content-box height="sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-6">
            <div>
                <x-h2>{{ $title }}</x-h2>

                @if ($message)
                    <p class="mt-1 text-gray-500 dark:text-gray-400 md:text-sm">{{ $message }}</p>
                @endif
            </div>

            @if ($actions?->isNotEmpty())
                <div class="shrink-0 flex flex-row-reverse justify-end md:flex-row items-center space-x-reverse space-x-6 md:space-x-6">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </x-content-box>

    {{ $slot }}
</div>
