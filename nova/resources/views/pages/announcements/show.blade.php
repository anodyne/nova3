<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading :heading="$announcement->title">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" variant="ghost">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>

                @can('update', $announcement)
                    <x-button :href="route('admin.announcements.edit', $announcement)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm"/>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-metadata.group gap="lg" class="my-4">
            <x-metadata label="Author" :value="$announcement->user->display_name"/>

            @if (filled($announcement->category))
                <x-metadata label="Category" :value="$announcement->category"/>
            @endif

            <x-metadata label="Published">
                <x-slot name="value">
                    @if (filled($announcement->published_at))
                        {{ $announcement->published_at->formatDate() }}
                    @else
                        <em class="text-warning-600">Unpublished</em>
                    @endif
                </x-slot>
            </x-metadata>
        </x-metadata.group>

        <div class="prose dark:prose-invert max-w-none">
            {!! $announcement->content !!}
        </div>
    </x-spacing>
</x-admin-layout>
