<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon :name="Icon::Globe" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h4 class="leading-8">Update the app URL</x-h4>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if (config('app.url') == url('/'))
            <x-icon :name="Icon::CheckCircle" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-icon :name="Icon::XmarkCircle" class="text-danger-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
