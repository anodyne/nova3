@use('Nova\Themes\Models\Theme')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            <x-button :href="external_content('theme-docs')" target="_blank" variant="ghost">
                <x-icon :name="Tabler::Book2" size="sm" />
                Learn more
            </x-button>

            @can('create', Theme::class)
                <x-button :href="route('admin.themes.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-heading>

    <livewire:themes-list />

    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-callout.primary :icon="Tabler::Brush" icon-size="xl">
            <div class="flex items-center justify-between gap-4">
                <p>Find more themes for your site on the Nova Add-on Exchange!</p>

                <x-link :href="external_content('exchange-link')" target="_blank" variant="heavy-primary">
                    Go
                    <span aria-hidden="true">→</span>
                </x-link>
            </div>
        </x-callout.primary>
    </div>
</x-admin-layout>
