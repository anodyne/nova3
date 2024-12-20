<x-write-post-wizard-layout
    :steps="[]"
    message="Compose your post. You’ll be able to set the content rating, summary, and order within the story before publishing."
>
    <x-spacing>
        <x-empty-state variant="jumbo">
            <x-icon name="lock-closed"></x-icon>
            <x-h2>Post locked</x-h2>
            <x-text size="lg">This post is currently locked and being edited. Please try again later.</x-text>

            <x-button :href="route('admin.posts.edit', $post)">
                <x-icon name="arrows-sync" size="sm"></x-icon>
                Refresh
            </x-button>
        </x-empty-state>
    </x-spacing>
</x-write-post-wizard-layout>
