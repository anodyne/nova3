@props([
    'stories'
])

<div>
    @foreach ($stories as $story)
        <div class="grid grid-cols-12 items-baseline relative p-3 sm:p-5 overflow-hidden" wire:key="story-{{ $story->id }}">
            <div class="col-start-1 col-span-1 row-start-1 md:row-end-3 flex items-center font-medium mb-1 md:mb-0">
                <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible">
                    <!-- Circle -->
                    <circle cx="6" cy="6" r="6" fill="currentColor" class="text-{{ $story->status->color() }}-9"></circle>

                    @if ($story->is_current)
                        <!-- Ring -->
                        <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-{{ $story->status->color() }}-9"></circle>
                    @endif

                    @if (request('sort', 'desc') === 'desc' && $story->getNextSibling())
                        <!-- Lower arm -->
                        <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                    @endif

                    @if (request('sort', 'desc') === 'asc' && $story->getPrevSibling())
                        <!-- Lower arm -->
                        <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                    @endif

                    @if (request('sort', 'desc') === 'desc' && $story->getPrevSibling())
                        <!-- Upper arm -->
                        <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                    @endif

                    @if (request('sort', 'desc') === 'asc' && $story->getNextSibling())
                        <!-- Upper arm -->
                        <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                    @endif
                </svg>
            </div>

            <div class="col-start-2 col-span-11 ml-0 text-gray-11">
                <h3 class="text-xl font-bold tracking-tight text-gray-12">{{ $story->title }}</h3>

                <p class="leading-7 mt-1">{{ $story->description }}</p>

                <div class="relative flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-8 mt-3 text-base md:text-sm text-gray-9">
                    <span>
                        <x-badge :color="$story->status->color()" size="xs">
                            @if ($story->is_current && $story->allow_posting)
                                <x-slot name="leadingIcon">
                                    @icon('edit', $component->iconStyles())
                                </x-slot>
                            @endif

                            {{ $story->status->displayName() }}
                        </x-badge>
                    </span>

                    @if ($story->post_count > 0)
                        <span class="font-medium">{{ $story->post_count }} @choice('post|posts', $story->post_count)</span>
                    @endif

                    @if ($story->getDescendantCount() > 0)
                        <span class="font-medium">{{ $story->all_stories_post_count }} posts in all stories</span>
                    @endif

                    @canany(['view', 'create', 'update', 'delete'], $story)
                        <span class="leading-0">
                            <x-button type="button" size="none" color="gray-blue-text" wire:click="selectStory('{{ $story->id }}')">
                                @icon('settings', 'h-6 w-6 flex-shrink-0')
                                <span>Manage</span>
                            </x-button>
                        </span>
                    @endcanany

                    @can('view', $story)
                        <span class="leading-0">
                            <x-link :href="route('stories.show', $story)" size="none" color="gray-blue-text">
                                @icon('arrow-right', 'h-6 w-6 flex-shrink-0')
                                <span>Go to story</span>
                            </x-link>
                        </span>
                    @endcan
                </div>

                @if ($story->getDescendantCount() > 0)
                    <div class="relative w-full">
                        <x-stories.timeline :stories="$story->children" />
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>