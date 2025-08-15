@use('Nova\Addons\Models\Addon')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <x-button :href="external_content('addon-docs')" target="_blank" variant="ghost">
                <x-icon :name="Tabler::Book2" size="sm" />
                Learn more
            </x-button>

            @can('create', Addon::class)
                <x-button :href="route('admin.addons.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:addons-list />

    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-callout.primary :icon="Tabler::Puzzle" icon:size="md">
            <div class="flex items-center justify-between gap-4">
                <p>Check out the Nova Add-on Exchange for more personalization choices!</p>

                <x-link :href="external_content('exchange-link')" target="_blank" variant="heavy-primary">
                    Go &rarr;
                </x-link>
            </div>
        </x-callout.primary>
    </div>
</x-admin-layout>
