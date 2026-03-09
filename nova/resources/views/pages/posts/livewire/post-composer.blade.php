@use('Nova\Foundation\Helpers\DateHelper')

<div wire:poll.300s.keep-alive="checkLock" wire:cloak>
    <div class="grid gap-12 lg:grid-cols-3">
        <section class="space-y-12 lg:col-span-2">
            <div class="space-y-6">
                <div class="relative z-10 flex items-center gap-x-2">
                    <div class="shrink text-sm/6 font-medium">
                        @if ($currentStories->count() >= 2)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <x-button variant="ghost" size="sm">
                                        <x-metadata label="Story" :value="$story->title" />
                                        <x-icon.micro.chevron-up-down class="size-4 text-gray-400 dark:text-gray-600" />
                                    </x-button>
                                </x-slot>

                                @foreach ($currentStories as $currentStory)
                                    <x-dropdown.item wire:click="changeStory({{ $currentStory->id }})">
                                        <div class="flex w-full items-center justify-between">
                                            <div class="flex flex-1 items-center gap-3">
                                                {{ $currentStory->title }}
                                            </div>

                                            @if ($currentStory->id === $story->id)
                                                <x-icon.micro.check class="size-4 shrink-0" />
                                            @endif
                                        </div>
                                    </x-dropdown.item>
                                @endforeach
                            </x-dropdown>
                        @else
                            <x-metadata label="Story" :value="$story->title" />
                        @endif
                    </div>

                    <div class="text-sm/6 font-medium text-gray-400 dark:text-gray-600">/</div>

                    <div class="shrink text-sm/6 font-medium">
                        @if ($post->is_draft)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <x-button variant="ghost" size="sm">
                                        <x-metadata label="Post type" :value="$postType->name" />
                                        <x-icon.micro.chevron-up-down class="size-4 text-gray-400 dark:text-gray-600" />
                                    </x-button>
                                </x-slot>

                                @foreach ($availablePostTypes as $availablePostType)
                                    <x-dropdown.item wire:click="startPostTypeChange({{ $availablePostType->id }})">
                                        <div class="flex w-full items-center justify-between">
                                            <div class="flex flex-1 items-center gap-3">
                                                <div class="shrink-0 text-gray-400 group-focus:text-gray-300">
                                                    <x-icon :name="$availablePostType->icon" size="sm" />
                                                </div>

                                                <div>{{ $availablePostType->name }}</div>
                                            </div>

                                            @if ($availablePostType->id === $postType->id)
                                                <x-icon.micro.check class="size-4 shrink-0" />
                                            @endif
                                        </div>
                                    </x-dropdown.item>
                                @endforeach
                            </x-dropdown>
                        @else
                            <x-metadata label="Post type" :value="$postType->name" />
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
                <div class="flex items-center justify-between gap-x-4">
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

                    @if ($shouldUsePostLock)
                        <div class="shrink-0">
                            <x-button wire:click="saveAndFinish(true)" variant="ghost" inset="right">
                                I’m done editing
                            </x-button>
                        </div>
                    @endif
                </div>
            @endif
        </section>

        <aside class="space-y-12">
            <div class="space-y-4">
                @can('publish', $post)
                    <div>
                        <x-button
                            wire:click="openForPublishing"
                            class="w-full"
                            variant="primary"
                            :disabled="! $canPublish"
                        >
                            Publish
                        </x-button>
                    </div>

                    @if (! $canPublish)
                        <x-callout.danger>
                            {!! $validationErrors !!}
                        </x-callout.danger>
                    @endif
                @endcan

                @if ($post->is_published)
                    <div>
                        <x-button wire:click="save" class="w-full" variant="primary">Update</x-button>
                    </div>
                @endif

                @can('delete', $post)
                    <div>
                        <x-button class="w-full" wire:click="delete" variant="ghost" data-danger>
                            <div class="flex items-center gap-2">
                                <x-icon :name="Tabler::Trash" size="sm" />
                                Delete post
                            </div>
                        </x-button>
                    </div>
                @endcan

                @can('discard', $post)
                    <div>
                        <x-button class="w-full" wire:click="discard" variant="ghost" data-danger>
                            <div class="flex items-center gap-2">
                                <x-icon :name="Tabler::Trash" size="sm" />
                                Discard draft
                            </div>
                        </x-button>
                    </div>
                @endcan
            </div>

            <x-accordion>
                <x-accordion.item expanded transition>
                    <x-accordion.heading>
                        <div class="flex items-center gap-x-2">
                            <x-icon :name="Tabler::MasksTheater" size="sm" />
                            <span>Authors</span>
                        </div>
                    </x-accordion.heading>

                    <x-accordion.content>
                        <livewire:posts-authors :$post @post-updated="handleUpdateFromChild" />
                    </x-accordion.content>
                </x-accordion.item>

                @if ($post?->postType?->fields?->rating?->enabled ?? false)
                    <x-accordion.item expanded transition>
                        <x-accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon :name="Tabler::Rating18Plus" size="sm" />
                                <span>Content ratings</span>
                            </div>
                        </x-accordion.heading>

                        <x-accordion.content>
                            <livewire:posts-ratings :$post @post-updated="handleUpdateFromChild" />
                        </x-accordion.content>
                    </x-accordion.item>
                @endif

                @if ($post?->postType?->fields?->summary?->enabled ?? false)
                    <x-accordion.item expanded transition>
                        <x-accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon :name="Tabler::Blockquote" size="sm" />
                                <span>Summary</span>
                            </div>
                        </x-accordion.heading>

                        <x-accordion.content>
                            <livewire:posts-summary :$post @post-updated="handleUpdateFromChild" />
                        </x-accordion.content>
                    </x-accordion.item>
                @endif

                @if ($post->exists)
                    <x-accordion.item expanded transition>
                        <x-accordion.heading>
                            <div class="flex items-center gap-x-2">
                                <x-icon :name="Tabler::TimelineEvent" size="sm" />
                                <span>Post position</span>
                            </div>
                        </x-accordion.heading>

                        <x-accordion.content>
                            <livewire:posts-position :$post @post-updated="handleUpdateFromChild" />
                        </x-accordion.content>
                    </x-accordion.item>
                @endif

                <x-accordion.item expanded transition>
                    <x-accordion.heading>
                        <div class="flex items-center gap-x-2">
                            <x-icon :name="Tabler::InfoCircle" size="sm" />
                            <span>Post info</span>
                        </div>
                    </x-accordion.heading>

                    <x-accordion.content>
                        <dl class="text-sm/6">
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/5 dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Status</dt>
                                <dd>
                                    <x-badge :color="$post->status->getColor()">
                                        {{ $post->status->getLabel() }}
                                    </x-badge>
                                </dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/5 dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Word count</dt>
                                <dd>
                                    {{ Number::format($post->word_count ?? 0) }}
                                </dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/5 dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Reading time</dt>
                                <dd>
                                    {{ $post->reading_time }}
                                </dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/5 dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Last update</dt>
                                <dd>{{ DateHelper::formatShortDateWithTime($post->updated_at) }}</dd>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-4 rounded-md px-2 py-1 odd:bg-gray-950/5 dark:odd:bg-white/[.07]"
                            >
                                <dt class="flex-1 font-medium text-gray-950 dark:text-white">Published</dt>

                                @if (filled($post->published_at))
                                    <dd>{{ DateHelper::formatShortDateWithTime($post->published_at) }}</dd>
                                @else
                                    <dd>&mdash;</dd>
                                @endif
                            </div>
                        </dl>
                    </x-accordion.content>
                </x-accordion.item>
            </x-accordion>
        </aside>
    </div>
</div>
