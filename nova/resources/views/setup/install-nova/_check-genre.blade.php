@use('Nova\Departments\Models\Department')
@use('Nova\Departments\Models\Position')

@php
    $isInstalled = Department::count() > 0 && Position::count() > 0;
@endphp

<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon name="characters" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h4 class="leading-8">Install {{ $this->genre }} genre data</x-h4>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($isInstalled)
            <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-icon name="x-circle" class="text-danger-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
