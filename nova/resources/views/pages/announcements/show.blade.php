@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$announcement->title">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" variant="ghost">&larr; Back</x-button>

                @can('update', $announcement)
                    <x-button :href="route('admin.announcements.edit', $announcement)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
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

            <x-metadata label="Published">
                <x-slot name="value">
                    @if (filled($announcement->published_at))
                        {{ DateHelper::formatDate($announcement->published_at) }}
                    @else
                        <em class="text-warning-600">Unpublished</em>
                    @endif
                </x-slot>
            </x-metadata>
        </div>

        <div class="prose dark:prose-invert max-w-none">
            {!! $announcement->content !!}
        </div>
    </x-spacing>
</x-admin-layout>
