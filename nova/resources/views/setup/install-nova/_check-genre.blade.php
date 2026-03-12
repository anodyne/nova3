@use('Nova\Departments\Models\Department')
@use('Nova\Departments\Models\Position')

@php
    $isInstalled = Department::count() > 0 && Position::count() > 0;
@endphp

<x-setup::panel.row :icon="Tabler::MasksTheater">
    <x-slot name="heading">Install {{ $this->genre }} genre data</x-slot>

    <x-slot name="trailing">
        @if ($isInstalled)
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
