@props([
    'stories',
    'selectedStory' => null,
])

<ul>
    @foreach ($stories as $story)
        <li class="relative flex w-full items-baseline gap-10">
            <div
                @class([
                    'before:absolute before:bottom-0 before:left-[5px] before:top-[54px] before:h-full before:w-0.5 before:bg-gray-300 dark:before:bg-gray-700' => ! $loop->last,
                    // 'after:absolute after:left-[5px] after:top-[52px] after:w-0.5 after:bg-gray-200 dark:after:bg-gray-700' => ! $loop->last,
                    '' => false,
                ])
            >
                <div
                    @class([
                        'z-10 h-3 w-3 rounded-full ring-2 ring-offset-4 ring-offset-white dark:ring-offset-gray-900',
                        $story->status->timelineMarker(),
                    ])
                ></div>
            </div>
            <div class="flex-1">
                <div class="flex-1">
                    <x-content-box width="none" height="none" class="my-6 flex items-baseline gap-6">
                        <div class="flex-1">
                            <x-h2 class="mb-1">{{ $story->title }}</x-h2>
                            <div class="leading-7 text-gray-600 dark:text-gray-400">{{ $story->description }}</div>
                            <div
                                class="relative mt-3 flex flex-col space-y-3 text-base md:flex-row md:items-center md:space-x-8 md:space-y-0 md:text-sm"
                            >
                                <span>
                                    <x-badge :color="$story->status->color()">
                                        {{ $story->status->displayName() }}
                                    </x-badge>
                                </span>

                                <span class="font-medium text-gray-500 dark:text-gray-400">
                                    {{ number_format((int) $story->posts_count) }}
                                    @choice('post|posts', $story->posts_count)
                                </span>

                                @if ($story->children->count() > 0)
                                    <span class="font-medium text-gray-500 dark:text-gray-400">
                                        {{ number_format((int) $story->recursive_posts_count) }} posts in all stories
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="shrink-0">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger">
                                    <x-icon.more class="h-7 w-7 md:h-6 md:w-6" />
                                </x-slot>

                                <x-dropdown.group>
                                    @can('view', $story)
                                        <x-dropdown.item :href="route('stories.show', $story)" icon="show">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $story)
                                        <x-dropdown.item :href="route('stories.edit', $story)" icon="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('view', $story)
                                    <x-dropdown.group>
                                        <x-dropdown.item icon="list">
                                            <span>Posts</span>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @endcan

                                @can('create', $story)
                                    <x-dropdown.group>
                                        <x-dropdown.header>Add a story</x-dropdown.header>
                                        <x-dropdown.item
                                            :href="route('stories.create', 'direction=before&neighbor='.$story->id)"
                                            icon="move-up"
                                        >
                                            Before this story
                                        </x-dropdown.item>
                                        <x-dropdown.item
                                            :href="route('stories.create', 'direction=after&neighbor='.$story->id)"
                                            icon="move-down"
                                        >
                                            <span>After this story</span>
                                        </x-dropdown.item>
                                        <x-dropdown.item
                                            :href="route('stories.create', 'parent='.$story->id)"
                                            icon="move-right"
                                        >
                                            <span>Inside this story</span>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @endcan

                                @can('delete', $story)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger :href="route('stories.delete', $story)" icon="trash">
                                            <span>Delete</span>
                                        </x-dropdown.item-danger>
                                    </x-dropdown.group>
                                @endcan
                            </x-dropdown>
                        </div>
                    </x-content-box>
                </div>

                @if ($story->children->count() > 0)
                    <div class="relative w-full">
                        <x-stories.timeline :stories="$story->children" />
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>

{{--
    <div>
    @foreach ($stories as $story)
    <div
    class="relative grid grid-cols-12 items-baseline overflow-hidden p-3 sm:p-5"
    wire:key="story-{{ $story->id }}"
    >
    <div class="col-span-1 col-start-1 row-start-1 mb-1 flex items-center font-medium md:row-end-3 md:mb-0">
    <svg viewBox="0 0 12 12" class="mr-6 h-3 w-3 overflow-visible">
    <!-- Circle -->
    <circle cx="6" cy="6" r="6" fill="currentColor" class="{{ $story->status->textColor() }}"></circle>
    
    @if ($story->is_current)
    <!-- Ring -->
    <circle
    cx="6"
    cy="6"
    r="11"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    class="{{ $story->status->textColor() }}"
    ></circle>
    @endif
    
    @unless ($loop->last)
    <!-- Lower arm -->
    <path
    d="M 6 18 V 100000"
    fill="none"
    stroke-width="2"
    stroke="currentColor"
    class="text-gray-300 dark:text-gray-700"
    ></path>
    @endunless
    
    @unless ($loop->first)
    <!-- Upper arm -->
    <path
    d="M 6 -6 V -30"
    fill="none"
    stroke-width="2"
    stroke="currentColor"
    class="text-gray-300 dark:text-gray-700"
    ></path>
    @endunless
    </svg>
    </div>
    
    <div class="relative col-span-11 col-start-2 ml-0">
    <div class="relative cursor-pointer rounded-lg bg-gray-100 px-6 py-4">
    <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
    {{ $story->title }}
    </h3>
    
    <p class="mt-1 leading-7">{{ $story->description }}</p>
    
    <div
    class="relative mt-3 flex flex-col space-y-3 text-base md:flex-row md:items-center md:space-x-8 md:space-y-0 md:text-sm"
    >
    <span>
    <x-badge :color="$story->status->color()">
    {{ $story->status->displayName() }}
    </x-badge>
    </span>
    
    <span class="font-medium text-gray-500 dark:text-gray-400">
    {{ number_format((int) $story->posts_count) }}
    @choice('post|posts', $story->posts_count)
    </span>
    
    @if ($story->children->count() > 0)
    <span class="font-medium text-gray-500 dark:text-gray-400">
    {{ number_format((int) $story->recursive_posts_count) }} posts in all stories
    </span>
    @endif
    
    @canany(['view', 'create', 'update', 'delete'], $story)
    <span class="leading-0">
    <x-button.text
    tag="button"
    color="gray"
    leading="settings"
    wire:click="selectStory('{{ $story->id }}')"
    >
    Manage
    </x-button.text>
    </span>
    @endcanany
    
    @can('view', $story)
    <span class="leading-0">
    <x-button.text
    :href="route('stories.show', $story)"
    color="gray"
    leading="arrow-right"
    >
    Go to story
    </x-button.text>
    </span>
    @endcan
    </div>
    </div>
    
    @if ($story->children->count() > 0)
    <div class="relative w-full">
    <x-stories.timeline :stories="$story->children" />
    </div>
    @endif
    </div>
    </div>
    @endforeach
    </div>
--}}
