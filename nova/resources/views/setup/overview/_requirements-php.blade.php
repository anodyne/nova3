<x-setup::panel.row :icon="Tabler::BrandPhp" heading="PHP 8.4+">
    <p>
        Nova is web-based software written in PHP. To ensure the best possible experience, we recommend using the latest
        version of PHP.
    </p>

    <p>Your server is currently running PHP {{ $e->php->version }}.</p>

    <x-slot name="trailing">
        @if ($e->php->passes())
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
