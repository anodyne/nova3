@use('Nova\Announcements\Models\Announcement')
@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-spacing constrained-lg>
        <x-page-header></x-page-header>

        <div class="space-y-12">
            @can('approveAny', Announcement::class)
                <x-panel variant="well">
                    <x-panel.header title="Announcements" :icon="Icon::Megaphone"></x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/10">
                        @forelse ($announcements as $announcement)
                            <x-spacing class="flex items-center justify-between" size="row">
                                <div class="flex flex-col gap-1">
                                    <x-h4 class="truncate">{{ $announcement->title }}</x-h4>

                                    <div class="flex items-center gap-x-4 text-sm/6">
                                        <x-metadata label="Author" :value="$announcement->user->name"></x-metadata>
                                        <x-metadata label="Category" :value="$announcement->category"></x-metadata>
                                    </div>
                                </div>

                                <div class="flex shrink-0 items-center gap-2">
                                    <flux:button
                                        :href="route('admin.announcements.show', $announcement)"
                                        variant="subtle"
                                        square
                                    >
                                        <x-icon :name="Icon::Show" size="sm"></x-icon>
                                    </flux:button>
                                    <flux:button :href="route('admin.announcements.index')" variant="subtle" square>
                                        <x-icon :name="Icon::Settings" size="sm"></x-icon>
                                    </flux:button>
                                </div>
                            </x-spacing>
                        @empty
                            <x-spacing size="row">
                                <x-text><x-text.strong>No pending announcements</x-text.strong></x-text>
                            </x-spacing>
                        @endforelse
                    </x-panel>
                </x-panel>
            @endcan

            @can('approveAny', Post::class)
                <x-panel variant="well">
                    <x-panel.header title="Posts" :icon="Icon::Write"></x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/10">
                        @forelse ($posts as $post)
                            <x-spacing class="flex items-center justify-between" size="row">
                                <div class="flex flex-col gap-1">
                                    <x-h4 class="truncate">{{ $post->title }}</x-h4>

                                    <div class="flex items-center gap-x-4 text-sm/6">
                                        <x-metadata label="Post type" :value="$post->postType->name"></x-metadata>
                                    </div>
                                </div>

                                <div class="flex shrink-0 items-center">
                                    <flux:button
                                        :href="route('admin.posts.show', ['story' => $post->story_id, 'post' => $post])"
                                        variant="subtle"
                                        square
                                    >
                                        <x-icon :name="Icon::Show" size="sm"></x-icon>
                                    </flux:button>
                                    <flux:button
                                        :href="route('admin.posts.index', 'status[]=pending')"
                                        variant="subtle"
                                        square
                                    >
                                        <x-icon :name="Icon::Settings" size="sm"></x-icon>
                                    </flux:button>
                                </div>
                            </x-spacing>
                        @empty
                            <x-spacing size="row">
                                <x-text><x-text.strong>No pending posts</x-text.strong></x-text>
                            </x-spacing>
                        @endforelse
                    </x-panel>
                </x-panel>
            @endcan
        </div>
    </x-spacing>
</x-admin-layout>
