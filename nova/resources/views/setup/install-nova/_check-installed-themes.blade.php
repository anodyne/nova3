@use('Nova\Themes\Models\Theme')

<x-setup::panel.row :icon="Tabler::Brush" heading="Install available themes">
    <x-slot name="trailing">
        @if (Theme::count() > 0)
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
