@props([
    'controls' => false,
])

@aware(['columns'])

<li {{ $attributes }}>
    <div class="block hover:bg-gray-50/50 dark:hover:bg-gray-700/20 focus:outline-none transition">
        <x-content-box height="sm" class="flex">
            <div class="min-w-0 flex-1 grid grid-cols-1 {{ $columns ? 'md:grid-cols-'.$columns : '' }} gap-4">
                {{ $slot }}
            </div>

            @if ($controls)
                <div class="ml-4 flex md:items-center">
                    {{ $controls }}
                </div>
            @endif
        </x-content-box>
    </div>
</li>