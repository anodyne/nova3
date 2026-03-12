@use('Nova\Announcements\Models\Announcement')
@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-spacing constrained-lg>
        <x-page-heading></x-page-heading>

        <div class="space-y-12">
            @can('approveAny', Announcement::class)
                <x-panel variant="well">
                    <x-panel.header title="Announcements" :icon="Tabler::Speakerphone"></x-panel.header>

                    <x-panel>
                        <x-spacing.group divided>
                            @forelse ($announcements as $announcement)
                                <x-panel.group.row>
                                    <div class="flex flex-col gap-1">
                                        <x-heading>{{ $announcement->title }}</x-heading>

                                        <x-metadata.group>
                                            <x-metadata label="Author" :value="$announcement->user->name"></x-metadata>
                                            <x-metadata label="Category" :value="$announcement->category"></x-metadata>
                                        </x-metadata.group>
                                    </div>

                                    <div class="flex shrink-0 items-center gap-2">
                                        <x-button
                                            :href="route('admin.announcements.show', $announcement)"
                                            variant="subtle"
                                            inset="top bottom"
                                            square
                                        >
                                            <x-icon :name="Tabler::Eye" size="sm" />
                                        </x-button>

                                        <x-button
                                            :href="route('admin.announcements.index')"
                                            variant="subtle"
                                            inset="right top bottom"
                                            square
                                        >
                                            <x-icon :name="Tabler::Settings" size="sm" />
                                        </x-button>
                                    </div>
                                </x-panel.group.row>
                            @empty
                                <x-spacing size="row">
                                    <x-text><strong>No pending announcements</strong></x-text>
                                </x-spacing>
                            @endforelse
                        </x-spacing.group>
                    </x-panel>
                </x-panel>
            @endcan

            @can('approveAny', Post::class)
                <x-panel variant="well">
                    <x-panel.header title="Posts" :icon="Tabler::Edit"></x-panel.header>

                    <x-panel>
                        <x-spacing.group divided>
                            @forelse ($posts as $post)
                                <x-panel.group.row>
                                    <div class="flex flex-col gap-1">
                                        <x-heading>{{ $post->title }}</x-heading>

                                        <div class="flex items-center gap-4 text-sm/6">
                                            <x-metadata label="Post type" :value="$post->postType->name"></x-metadata>
                                        </div>
                                    </div>

                                    <div class="flex shrink-0 items-center">
                                        <x-button
                                            :href="route('admin.posts.show', ['story' => $post->story_id, 'post' => $post])"
                                            variant="subtle"
                                            inset="top bottom"
                                            square
                                        >
                                            <x-icon :name="Tabler::Eye" size="sm" />
                                        </x-button>

                                        <x-button
                                            :href="route('admin.posts.index', 'status[]=pending')"
                                            variant="subtle"
                                            inset="right top bottom"
                                            square
                                        >
                                            <x-icon :name="Tabler::Settings" size="sm" />
                                        </x-button>
                                    </div>
                                </x-panel.group.row>
                            @empty
                                <x-spacing size="row">
                                    <x-text><strong>No pending posts</strong></x-text>
                                </x-spacing>
                            @endforelse
                        </x-spacing.group>
                    </x-panel>
                </x-panel>
            @endcan
        </div>
    </x-spacing>
</x-admin-layout>
