@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$announcement->title">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" plain>&larr; Back</x-button>

                @can('update', $announcement)
                    <x-button :href="route('admin.announcements.edit', $announcement)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <div class="my-4 flex items-center gap-x-8 text-sm">
            <x-metadata label="Author" :value="$announcement->user->name"></x-metadata>

            @if (filled($announcement->category))
                <x-metadata label="Category" :value="$announcement->category"></x-metadata>
            @endif

            <x-metadata label="Published" :value="DateHelper::formatDate($announcement->published_at)"></x-metadata>
        </div>

        <div class="prose max-w-none dark:prose-invert">
            {!! $announcement->content !!}
        </div>
    </x-spacing>
</x-admin-layout>
