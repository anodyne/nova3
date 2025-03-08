<x-spacing constrained>
    <x-empty-state variant="jumbo">
        <x-icon name="lock-closed"></x-icon>
        <x-h2>Post locked</x-h2>
        <x-text class="text-pretty" size="lg">
            {{-- format-ignore-start --}}
            This post is currently locked and being edited by
            <x-text.strong>{{ $post->lockOwner->name }}.</x-text.strong> Please try again shortly.
            {{-- format-ignore-end --}}
        </x-text>

        <div class="flex items-center gap-8" data-slot="button">
            <x-button :href="route('admin.posts.edit', $post)">
                <x-icon name="arrows-sync" size="sm"></x-icon>
                Refresh
            </x-button>

            @can('unlock', $post)
                <x-button :href="route('admin.posts.edit', $post)">
                    <x-icon name="lock-open" size="sm"></x-icon>
                    Unlock
                </x-button>
            @endcan
        </div>
    </x-empty-state>
</x-spacing>
