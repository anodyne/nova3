@aware(['columns'])

<li class="hidden md:block border-t border-gray-200 dark:border-gray-200/5 bg-gray-50 dark:bg-gray-700/40 text-sm font-medium text-gray-500 dark:text-gray-400">
    <div class="block">
        <x-content-box height="xs" class="flex">
            <div class="min-w-0 flex-1 grid grid-cols-1 {{ $columns ? 'grid-cols-'.$columns : '' }} gap-4">
                {{ $slot }}
            </div>
            <div class="block ml-4 w-6"></div>
        </x-content-box>
    </div>
</li>
