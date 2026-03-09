<x-spacing constrained>
    <x-empty variant="jumbo">
        <x-illustration :name="Illustration::Padlock"></x-illustration>
        <x-empty.heading>Post locked</x-empty.heading>
        <x-empty.text>
            {{-- format-ignore-start --}}
            This post is currently locked and being edited by
            <strong>{{ $post->lockOwner->name }}.</strong> Please try again shortly.
            {{-- format-ignore-end --}}
        </x-empty.text>

        <div class="flex items-center gap-8" data-slot="button">
            <x-button :href="route('admin.posts.edit', $post)">
                <x-icon :name="Tabler::Refresh" size="sm" />
                Refresh
            </x-button>

            @can('unlock', $post)
                <x-button :href="route('admin.posts.edit', $post)">
                    <x-icon :name="Tabler::LockOpen" size="sm" />
                    Unlock
                </x-button>
            @endcan
        </div>
    </x-empty>
</x-spacing>
