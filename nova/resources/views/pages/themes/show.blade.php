<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$theme->name" :description="'themes/'.$theme->location">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" plain>&larr; Back</x-button>

                @can('update', $theme)
                    <x-button :href="route('admin.themes.edit', $theme)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-panel well>
                <x-panel>
                    <img
                        src="{{ asset('themes/'.$theme->location.'/'.$theme->preview) }}"
                        alt=""
                        class="max-h-96 w-full rounded-lg object-cover"
                    />
                </x-panel>
            </x-panel>

            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field label="Credits">
                        <x-text>{{ $theme->credits }}</x-text>
                    </x-fieldset.field>

                    @if (settings('appearance.theme') === $theme->name)
                        <div>
                            <x-badge color="primary">Currently selected theme for public site</x-badge>
                        </div>
                    @endif
                </x-fieldset.field-group>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
