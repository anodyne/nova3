@extends($meta->template)

@use('Nova\Pages\Models\Page')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">{{ $page->name }}</x-slot>
            <x-slot name="description">
                <span class="flex items-center gap-x-4">
                    <x-badge :color="$page->status->color()" size="md">
                        {{ $page->status->getLabel() }}
                    </x-badge>

                    <x-badge :color="$page->is_basic ? 'info' : 'primary'" size="md">
                        {{ $page->is_basic ? 'Basic page' : 'Advanced page' }}
                    </x-badge>
                </span>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $page::class)
                    <x-button :href="route('pages.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $page)
                    <x-button :href="route('pages.design', $page)" color="neutral">
                        <x-icon name="tools" size="sm"></x-icon>
                        Design
                    </x-button>

                    <x-button :href="route('pages.edit', $page)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field>
                        <x-fieldset.label>URL</x-fieldset.label>
                        <x-text>{{ url($page->uri) }}</x-text>
                    </x-fieldset.field>

                    <x-fieldset.field>
                        <x-fieldset.label>Key</x-fieldset.label>
                        <x-text>{{ $page->key }}</x-text>
                    </x-fieldset.field>

                    <x-fieldset.field>
                        <x-fieldset.label>HTTP Verb</x-fieldset.label>
                        <div data-slot="description">
                            <x-badge :color="$page->verb->color()">{{ $page->verb->getLabel() }}</x-badge>
                        </div>
                    </x-fieldset.field>

                    @if (filled($page->resource))
                        <x-fieldset.field>
                            <x-fieldset.label>Resource</x-fieldset.label>
                            <x-text>{{ $page->resource }}</x-text>
                        </x-fieldset.field>
                    @endif

                    @if ($page->is_basic)
                        <x-fieldset.field>
                            <x-fieldset.label>Last updated</x-fieldset.label>
                            <x-text>{{ $page->updated_at?->diffForHumans() ?? 'Never' }}</x-text>
                        </x-fieldset.field>

                        <x-fieldset.field>
                            <x-fieldset.label>Last published</x-fieldset.label>
                            <x-text>{{ $page->published_at?->diffForHumans() ?? 'Never' }}</x-text>
                        </x-fieldset.field>
                    @endif
                </x-fieldset.field-group>
            </x-fieldset>

            @if ($page->is_basic)
                <x-fieldset.controls>
                    <x-button :href="url($page->uri)">
                        <x-icon name="www" size="sm"></x-icon>
                        Visit live page
                    </x-button>

                    <x-button :href="route('preview-basic-page', $page->key)">
                        <x-icon name="www-preview" size="sm"></x-icon>
                        Preview page
                    </x-button>
                </x-fieldset.controls>
            @endif
        </x-form>
    </x-spacing>
@endsection
