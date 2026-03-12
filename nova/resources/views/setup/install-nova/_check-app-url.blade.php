<x-setup::panel.row :icon="Tabler::World" heading="Update the app URL">
    <x-slot name="trailing">
        @if (config('app.url') == url('/'))
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
