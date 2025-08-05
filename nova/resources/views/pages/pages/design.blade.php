@use('Nova\Pages\Models\Page')

@pushOnce('styles')
<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.bunny.net/css?family=flow-circular:400" rel="stylesheet" />
@endPushOnce

<x-admin-layout>
    <x-page-header>
        <x-slot name="heading">Design page &ndash; {{ $page->name }}</x-slot>

        <x-slot name="actions">
            @can('viewAny', $page::class)
                <x-button :href="route('admin.pages.index')" plain>&larr; Back</x-button>
            @endcan

            <x-button :href="route('preview-basic-page', $page->key)" target="_blank">
                <x-icon :name="Icon::WwwPreview" size="sm"></x-icon>
                Preview page
            </x-button>

            <x-button :href="url($page->uri)" target="_blank">
                <x-icon :name="Icon::Www" size="sm"></x-icon>
                Visit live page
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="my-8 max-w-2xl space-y-8">
        @if (is_null($page->published_at))
            <x-panel.warning
                title="Unpublished changes"
                :icon="Icon::Progress"
                description="Your page blocks have not been published yet. Nova only shows published page blocks, so to ensure users are seeing the page with your latest changes, please publish your page."
            ></x-panel.warning>
        @else
            @if ($page->updated_at->gt($page->published_at))
                <x-panel.warning
                    title="Unpublished changes"
                    :icon="Icon::Progress"
                    description="Your page block(s) have been saved since you last published them. Nova only shows published page blocks, so to ensure users are seeing the page with your latest changes, please publish your page."
                ></x-panel.warning>
            @endif
        @endif
    </div>

    <livewire:pages-designer :page="$page" />
</x-admin-layout>
