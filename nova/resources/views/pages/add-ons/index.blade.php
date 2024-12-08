@use('Nova\Addons\Models\Addon')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <x-button href="https://anodyne-productions.com/docs/3.0/addons/overview" target="_blank" plain>
                <x-icon name="book" size="sm"></x-icon>
                Learn more
            </x-button>

            @can('create', Addon::class)
                <x-button :href="route('admin.addons.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:addons-list />

    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-panel.primary icon="puzzle">
            <div class="flex-1 md:flex md:justify-between">
                <p class="text-base md:text-sm">
                    Looking for more add-ons for your game? Check out the Nova Add-on Exchange!
                </p>
                <p class="mt-3 shrink-0 text-base md:ml-6 md:mt-0 md:text-sm">
                    <x-button :href="config('services.anodyne.links.exchange')" target="_blank" color="primary" text>
                        Go &rarr;
                    </x-button>
                </p>
            </div>
        </x-panel.primary>
    </div>
</x-admin-layout>
