<x-spacing size="sm" class="grid grid-cols-4 gap-4">
    <div class="col-span-3 font-medium text-gray-900">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-icon name="tabler-world" size="xl" class="text-gray-500"></x-icon>
            </div>
            <x-h4 class="flex-1">Update the app URL</x-h4>
        </div>
    </div>
    <div class="flex justify-end">
        @if (config('app.url') == url('/'))
            <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-icon name="tabler-circle-x" class="text-danger-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
