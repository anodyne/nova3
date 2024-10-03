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
            <div class="flex items-center gap-x-1.5 text-gray-500">
                <span>Author</span>
                <span class="font-medium text-gray-600 dark:text-gray-400">
                    {{ $announcement->user->name }}
                </span>
            </div>

            @if (filled($announcement->category))
                <div class="flex items-center gap-x-1.5 text-gray-500">
                    <span>Category</span>
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ $announcement->category }}
                    </span>
                </div>
            @endif

            <div class="flex items-center gap-x-1.5 text-gray-500">
                <span>Published</span>
                <span class="font-medium text-gray-600 dark:text-gray-400">
                    {{ format_date($announcement->published_at) }}
                </span>
            </div>
        </div>

        <div class="prose max-w-none">
            {!! $announcement->content !!}
        </div>
    </x-spacing>
</x-admin-layout>
