@use('Nova\Pages\Models\Page')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                @can('viewAny', $page::class)
                    <x-button :href="route('admin.pages.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $page)
                    <x-button :href="route('admin.pages.design', $page)">
                        <x-icon :name="Tabler::Tools" size="sm" />
                        Design
                    </x-button>

                    <x-button :href="route('admin.pages.edit', $page)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.group>
                    <x-input.display label="Name">
                        <x-text>{{ $page->name }}</x-text>
                    </x-input.display>

                    <x-input.display label="Type">
                        <x-badge :color="$page->is_basic ? 'info' : 'primary'" size="md">
                            {{ $page->is_basic ? 'Basic page' : 'Advanced page' }}
                        </x-badge>
                    </x-input.display>

                    <x-input.display label="URL">
                        <x-text>{{ url($page->uri) }}</x-text>
                    </x-input.display>

                    <x-input.display label="Key">
                        <x-text>{{ $page->key }}</x-text>
                    </x-input.display>

                    <x-input.display label="HTTP Verb">
                        <x-badge :color="$page->verb->getColor()" size="md">
                            {{ $page->verb->getLabel() }}
                        </x-badge>
                    </x-input.display>

                    <x-input.display label="Status">
                        <x-badge :color="$page->status->getColor()" size="md">
                            {{ $page->status->getLabel() }}
                        </x-badge>
                    </x-input.display>

                    @if (filled($page->resource))
                        <x-input.display label="Resource">
                            <x-text>{{ $page->resource }}</x-text>
                        </x-input.display>
                    @endif

                    @if ($page->is_basic)
                        <x-input.display label="Last updated">
                            <x-text>{{ $page->updated_at?->diffForHumans() ?? 'Never' }}</x-text>
                        </x-input.display>

                        <x-input.display label="Last published">
                            <x-text>{{ $page->published_at?->diffForHumans() ?? 'Never' }}</x-text>
                        </x-input.display>
                    @endif
                </x-fieldset.group>
            </x-fieldset>

            @if ($page->is_basic)
                <x-fieldset.controls>
                    <x-button :href="url($page->uri)">
                        <x-icon :name="Tabler::WorldWww" size="sm" />
                        Visit live page
                    </x-button>

                    <x-button :href="route('preview-basic-page', $page->key)">
                        <x-icon :name="Tabler::WorldSearch" size="sm" />
                        Preview page
                    </x-button>
                </x-fieldset.controls>
            @endif
        </x-form>
    </x-spacing>
</x-admin-layout>
