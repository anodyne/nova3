@props([
    'title',
    'message' => false,
    'actions' => null,
    'border' => true,
])

<div @class([
    'border-b border-gray-200 dark:border-gray-800' => $border,
])>
    <x-content-box height="sm">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-x-6 md:space-y-0">
            <div>
                <x-h2>{{ $title }}</x-h2>

                @if ($message)
                    <p class="mt-1 max-w-2xl text-gray-500 dark:text-gray-400 md:text-sm/6">{{ $message }}</p>
                @endif
            </div>

            @if ($actions?->isNotEmpty())
                <div
                    class="flex shrink-0 flex-row-reverse items-center justify-end space-x-6 space-x-reverse md:flex-row md:space-x-6"
                >
                    {{ $actions }}
                </div>
            @endif
        </div>
    </x-content-box>

    {{ $slot }}
</div>
