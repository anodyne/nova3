@use('Illuminate\Support\Number')
@use('Nova\Foundation\Helpers\DateHelper')

<div wire:poll.300s.keep-alive="checkLock" wire:cloak>
    <div class="grid gap-12 lg:grid-cols-3">
        <section class="space-y-12 lg:col-span-2">
            <div class="space-y-6">
                <div class="relative z-10 flex items-center gap-x-2">
                    <div class="-ml-2 shrink text-sm/6 font-medium">
                        <x-dropdown.breadcrumb>
                            @if ($currentStories->count() >= 2)
                                <x-slot name="trigger">
                                    <x-metadata label="Story" :value="$story->title"></x-metadata>
                                </x-slot>
                            @else
                                <x-slot name="placeholder">
                                    <x-metadata label="Story" :value="$story->title"></x-metadata>
                                </x-slot>
                            @endif

                            @foreach ($currentStories as $currentStory)
                                <x-dropdown.breadcrumb.item wire:click="changeStory({{ $currentStory->id }})">
                                    {{ $currentStory->title }}
                                </x-dropdown.breadcrumb.item>
                            @endforeach
                        </x-dropdown.breadcrumb>
                    </div>

                    <div class="text-sm/6 font-medium text-gray-400 dark:text-gray-600">/</div>

                    <div class="shrink text-sm/6 font-medium">
                        @if ($post->is_draft)
                            <x-dropdown.breadcrumb>
                                @if ($availablePostTypes->count() >= 2)
                                    <x-slot name="trigger">
                                        <x-metadata label="Post type" :value="$postType->name"></x-metadata>
                                    </x-slot>
                                @else
                                    <x-slot name="placeholder">
                                        <x-metadata label="Post type" :value="$postType->name"></x-metadata>
                                    </x-slot>
                                @endif

                                @foreach ($availablePostTypes as $availablePostType)
                                    <x-dropdown.breadcrumb.item
                                        wire:click="startPostTypeChange({{ $availablePostType->id }})"
                                        :selected="$availablePostType->id === $postTypeId"
                                    >
                                        <div class="flex items-center gap-x-1.5">
                                            <div class="shrink-0 text-gray-400 dark:text-gray-600">
                                                <x-icon :name="$availablePostType->icon" size="sm"></x-icon>
                                            </div>

                                            <div>{{ $availablePostType->name }}</div>
                                        </div>
                                    </x-dropdown.breadcrumb.item>
                                @endforeach
                            </x-dropdown.breadcrumb>
                        @else
                            <x-metadata label="Post type" :value="$postType->name"></x-metadata>
                        @endif
                    </div>

                    <div class="text-sm/6 font-medium text-gray-400 dark:text-gray-600">/</div>

                    <div class="shrink text-sm/6 font-medium">
                        <x-metadata label="Status" :value="$post->status->getLabel()"></x-metadata>
                    </div>
                </div>

                <livewire:posts-details :$post @post-updated="handleUpdateFromChild" />
            </div>

            @if ($post->is_draft)
                <div class="flex items-center gap-x-2">
                    @if ($postIsDirty)
                        <x-panel variant="well" color="warning">
                            <x-spacing height="3xs" left="3xs" right="sm" class="flex items-center gap-x-3">
                                <x-button wire:click="save" color="warning">Save</x-button>
                                <x-text color="warning" class="font-medium">
                                    There are unsaved changes to your post
                                </x-text>
                            </x-spacing>
                        </x-panel>
                    @else
                        <x-spacing height="3xs" left="3xs" right="sm">
                            <x-button wire:click="save">Save</x-button>
                        </x-spacing>
                    @endif
                </div>
            @endif
        </section>

        <aside class="space-y-12">
            <div class="space-y-4">
                @can('publish', $post)
                    <div>
                        <x-button wire:click="openForPublishing" class="w-full" color="primary">Publish</x-button>
                    </div>
                @endcan

                @if ($post->is_published)
                    <div>
                        <x-button wire:click="save" class="w-full" color="primary">Update</x-button>
                    </div>
                @endif

                @can('delete', $post)
                    <div>
                        <x-button class="w-full" wire:click="delete" color="neutral-danger" text>
                            <x-icon name="trash" size="sm"></x-icon>
                            Delete post
                        </x-button>
                    </div>
                @endcan

                @can('discard', $post)
                    <div>
                        <x-button class="w-full" wire:click="discard" color="neutral-danger" text>
                            <x-icon name="trash" size="sm"></x-icon>
                            Discard draft
                        </x-button>
                    </div>
                @endcan
            </div>

            <flux:accordion>
                <flux:accordion.item expanded transition>
                    <flux:accordion.heading>
                        <div class="flex items-center gap-x-2">
                            <x-icon name="characters" size="sm"></x-icon>
                            <span>Authors</span>
                        </div>
                    </flux:accordion.heading>

                    <flux:accordion.content>
                        <livewire:posts-authors :$post @post-updated="handleUpdateFromChild" />
                    </flux:accordion.content>
                </flux:accordion.item>

                @if ($post?->postType?->fields?->rating?->enabled ?? false)
                    <flux:accordion.item expanded transition>
                        <flux:accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon name="mature" size="sm"></x-icon>
                                <span>Content ratings</span>
                            </div>
                        </flux:accordion.heading>

                        <flux:accordion.content>
                            <livewire:posts-ratings :$post @post-updated="handleUpdateFromChild" />
                        </flux:accordion.content>
                    </flux:accordion.item>
                @endif

                @if ($post?->postType?->fields?->summary?->enabled ?? false)
                    <flux:accordion.item expanded transition>
                        <flux:accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon name="blockquote" size="sm"></x-icon>
                                <span>Summary</span>
                            </div>
                        </flux:accordion.heading>

                        <flux:accordion.content>
                            <livewire:posts-summary :$post @post-updated="handleUpdateFromChild" />
                        </flux:accordion.content>
                    </flux:accordion.item>
                @endif

                @if ($post->exists)
                    <flux:accordion.item expanded transition>
                        <flux:accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon name="timeline" size="sm"></x-icon>
                                <span>Post position</span>
                            </div>
                        </flux:accordion.heading>

                        <flux:accordion.content>
                            <livewire:posts-position :$post @post-updated="handleUpdateFromChild" />
                        </flux:accordion.content>
                    </flux:accordion.item>
                @endif

                <flux:accordion.item expanded transition>
                    <flux:accordion.heading>
                        <div class="flex items-center gap-x-2">
                            <x-icon name="info" size="sm"></x-icon>
                            <span>Post info</span>
                        </div>
                    </flux:accordion.heading>

                    <flux:accordion.content>
                        <dl class="text-sm/6">
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Status</dt>
                                <dd>
                                    <x-badge :color="$post->status->getColor()" size="sm">
                                        {{ $post->status->getLabel() }}
                                    </x-badge>
                                </dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Word count</dt>
                                <dd>
                                    {{ Number::format($post->word_count ?? 0) }}
                                </dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Reading time</dt>
                                <dd>
                                    {{ $post->reading_time }}
                                </dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Last update</dt>
                                <dd>{{ DateHelper::formatShortDateWithTime($post->updated_at) }}</dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Published</dt>

                                @if (filled($post->published_at))
                                    <dd>{{ DateHelper::formatShortDateWithTime($post->published_at) }}</dd>
                                @else
                                    <dd>&ndash;</dd>
                                @endif
                            </div>
                        </dl>
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </aside>
    </div>
</div>
