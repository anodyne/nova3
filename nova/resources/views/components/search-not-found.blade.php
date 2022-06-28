<x-content-box height="sm">
    <div class="rounded-md bg-warning-50 dark:bg-warning-900/50 border border-warning-300 dark:border-warning-700 text-warning-600 dark:text-warning-500 p-4">
        <div class="flex items-start">
            <div class="shrink-0">
                @icon('warning', 'h-7 w-7 md:h-6 md:w-6 text-warning-500 dark:text-warning-600')
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-base font-medium text-warning-600 dark:text-warning-500">
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</x-content-box>
