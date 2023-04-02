@props([
    'actions' => null,
])

@aware(['columns'])

<li {{ $attributes }}>
    <div class="block hover:bg-gray-25 dark:hover:bg-gray-700/20 focus:outline-none transition">
        <x-content-box height="sm" class="flex">
            <div class="min-w-0 flex-1 grid grid-cols-1 {{ $columns ? 'md:grid-cols-'.$columns : '' }} gap-4">
                {{ $slot }}
            </div>

            @if ($actions?->isNotEmpty())
                <div class="ml-4 min-w-6 flex md:items-center">
                    {{ $actions }}
                </div>
            @endif
        </x-content-box>
    </div>
</li>
