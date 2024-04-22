@extends($meta->template)

@use('Nova\Pages\Models\Page')

@pushOnce('styles')
<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.bunny.net/css?family=flow-circular:400" rel="stylesheet" />
@endPushOnce

@section('content')
    <x-page-header>
        <x-slot name="heading">Design page</x-slot>

        <x-slot name="actions">
            @can('viewAny', $page::class)
                <x-button :href="route('pages.index')" plain>&larr; Back</x-button>
            @endcan

            <x-button :href="route('preview-basic-page', $page->key)">
                <x-icon name="show"></x-icon>
                Preview page
            </x-button>

            <x-button :href="url($page->uri)">
                <x-icon name="www"></x-icon>
                Visit live page
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="my-8 max-w-2xl">
        <x-panel.primary title="Please note" icon="show">
            The preview below is not intended to be a high fidelity representation of your page. Once you save your
            page, you will be able to preview it in the browser.
        </x-panel.primary>
    </div>

    <livewire:pages-designer :page="$page" />
@endsection
