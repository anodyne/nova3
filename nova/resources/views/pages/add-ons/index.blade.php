@use('Nova\Addons\Models\Addon')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <x-button :href="external_content('addon-docs')" target="_blank" plain>
                <x-icon :name="Icon::Book" size="sm"></x-icon>
                Learn more
            </x-button>

            @can('create', Addon::class)
                <x-button :href="route('admin.addons.create')" color="primary">
                    <x-icon :name="Icon::Plus" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:addons-list />

    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-panel.primary :icon="Icon::Puzzle" icon-size="xl">
            <x-slot name="description">
                <div class="flex-1 md:flex md:justify-between">
                    <p class="text-base md:text-sm">
                        Looking for more add-ons for your game? Check out the Nova Add-on Exchange!
                    </p>
                    <p class="mt-3 shrink-0 text-base md:mt-0 md:ml-6 md:text-sm">
                        <x-button :href="external_content('exchange-link')" target="_blank" color="primary" text>
                            Go &rarr;
                        </x-button>
                    </p>
                </div>
            </x-slot>
        </x-panel.primary>
    </div>
</x-admin-layout>
