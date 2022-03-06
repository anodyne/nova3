<x-content-box height="sm">
    <div class="rounded-md bg-yellow-3 border border-yellow-6 p-4">
        <div class="flex items-start">
            <div class="shrink-0">
                @icon('warning', 'h-7 w-7 md:h-6 md:w-6 text-yellow-9')
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-base font-medium text-yellow-11">
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</x-content-box>
