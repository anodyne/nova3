@use('Nova\Stories\Enums\PostSorting')

<x-spacing width="sm" class="flex flex-col gap-8">
    <div class="flex items-center gap-4">
        <x-input placeholder="Find a story post" wire:model.live.debounce="search" clearable>
            <x-slot name="icon">
                <x-icon :name="Tabler::Search" size="sm" />
            </x-slot>
        </x-input>

        <x-dropdown>
            <x-slot name="trigger">
                <x-button>
                    <x-icon :name="Tabler::ArrowsSort" size="sm" />
                    Sort by
                </x-button>
            </x-slot>

            <flux:menu.radio.group wire:model.live="sort">
                @foreach (PostSorting::cases() as $sorting)
                    <flux:menu.radio :value="$sorting->value">{{ $sorting->getLabel() }}</flux:menu.radio>
                @endforeach
            </flux:menu.radio.group>
        </x-dropdown>

        <x-dropdown>
            <x-slot name="trigger">
                <x-button>
                    <x-icon :name="Tabler::PencilCog" size="sm" />
                    Post types
                    <x-badge>{{ count($types) }}</x-badge>
                </x-button>
            </x-slot>

            <flux:menu.checkbox.group wire:model.live="types" keep-open>
                @foreach ($postTypes as $types)
                    <flux:menu.checkbox :value="$types->id">{{ $types->name }}</flux:menu.checkbox>
                @endforeach
            </flux:menu.checkbox.group>
        </x-dropdown>

        @if ($multiStory)
            <x-dropdown>
                <x-slot name="trigger">
                    <x-button>
                        <x-icon :name="Tabler::Book2" size="sm" />
                        Story

                        @if (filled($selected))
                            <x-icon.micro.check-circle class="text-primary-500 size-4" />
                        @endif
                    </x-button>
                </x-slot>

                <flux:menu.radio.group wire:model.numeric.live="selected">
                    @foreach ($stories as $filterStory)
                        <flux:menu.radio :value="$filterStory->id">{{ $filterStory->title }}</flux:menu.radio>
                    @endforeach
                </flux:menu.radio.group>
            </x-dropdown>
        @endif

        <x-button type="button" wire:click="resetFilters" variant="subtle" inset="right">Reset</x-button>
    </div>

    <div class="flex flex-col gap-12">
        @forelse ($posts as $post)
            <div class="group relative flex flex-col items-start gap-3">
                <div class="z-10">
                    <x-badge type="pill" size="md">
                        <x-slot name="leading">
                            <x-badge type="pill" size="md" variant="inset" style="color:{{ $post->postType->color }}">
                                {{ $post->postType->name }}
                            </x-badge>
                        </x-slot>

                        {{ $post->reading_time }} read
                    </x-badge>
                </div>

                <x-heading size="lg" level="2">
                    <div
                        class="absolute -inset-x-4 -inset-y-4 z-0 scale-95 bg-gray-50 opacity-0 transition group-hover:scale-100 group-hover:opacity-100 sm:rounded-xl dark:bg-gray-900"
                    ></div>

                    <a href="{{ route('admin.posts.show', ['story' => $post->story, 'post' => $post]) }}">
                        <span class="absolute -inset-x-4 -inset-y-4 z-20 sm:rounded-xl"></span>
                        <span class="relative z-10">{{ $post->title }}</span>
                    </a>
                </x-heading>

                <x-feed.post-meta-fields :$post class="z-10">
                    @if ($multiStory)
                        <x-slot name="leading">
                            <x-metadata :icon="Tabler::Book2" :value="$post->story->title" />
                        </x-slot>
                    @endif

                    @if ($post->is_published)
                        <x-slot name="trailing">
                            <x-metadata
                                :icon="Tabler::CalendarClock"
                                :value="DateHelper::formatDate($post->published_at)"
                            />
                        </x-slot>
                    @endif
                </x-feed.post-meta-fields>

                @if ($post->postType->options->showContentInTimelineView)
                    <div class="prose dark:prose-invert relative z-10 max-w-4xl">
                        {!! $post->content !!}
                    </div>
                @endif

                <div class="z-10 flex items-center gap-4">
                    <x-avatar.group class="group-hover:**:ring-gray-50 dark:group-hover:**:ring-gray-900">
                        @foreach ($post->authors_avatars as $src)
                            <x-avatar :$src size="md" />
                        @endforeach
                    </x-avatar.group>

                    <x-text class="truncate">{{ $post->authors_string }}</x-text>
                </div>
            </div>
        @empty
            <x-empty>
                <x-illustration :name="Illustration::Book" />
                <x-empty.heading>No published posts found</x-empty.heading>
            </x-empty>
        @endforelse

        {{ $posts->links() }}
    </div>
</x-spacing>
