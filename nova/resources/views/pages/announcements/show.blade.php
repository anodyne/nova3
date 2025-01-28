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
            <div class="flex items-center gap-x-1 text-gray-500">
                <span>Author</span>
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $announcement->user->name }}
                </span>
            </div>

            @if (filled($announcement->category))
                <div class="flex items-center gap-x-1 text-gray-500">
                    <span>Category</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $announcement->category }}
                    </span>
                </div>
            @endif

            <div class="flex items-center gap-x-1 text-gray-500">
                <span>Published</span>
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ DateHelper::formatDate($announcement->published_at) }}
                </span>
            </div>
        </div>

        <div class="prose max-w-none dark:prose-invert">
            {!! $announcement->content !!}
        </div>
    </x-spacing>
</x-admin-layout>
