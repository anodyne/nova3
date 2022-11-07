@props([
    'stories'
])

<div>
    @foreach ($stories as $story)
        <div class="grid grid-cols-12 items-baseline relative p-3 sm:p-5 overflow-hidden" wire:key="story-{{ $story->id }}">
            <div class="col-start-1 col-span-1 row-start-1 md:row-end-3 flex items-center font-medium mb-1 md:mb-0">
                <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible">
                    <!-- Circle -->
                    <circle cx="6" cy="6" r="6" fill="currentColor" class="{{ $story->status->textColor() }}"></circle>

                    @if ($story->is_current)
                        <!-- Ring -->
                        <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="{{ $story->status->textColor() }}"></circle>
                    @endif

                    @if (request('sort', 'desc') === 'desc' && $story->getNextSibling())
                        <!-- Lower arm -->
                        <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-300 dark:text-gray-600"></path>
                    @endif

                    @if (request('sort', 'desc') === 'asc' && $story->getPrevSibling())
                        <!-- Lower arm -->
                        <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-300 dark:text-gray-600"></path>
                    @endif

                    @if (request('sort', 'desc') === 'desc' && $story->getPrevSibling())
                        <!-- Upper arm -->
                        <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-300 dark:text-gray-600"></path>
                    @endif

                    @if (request('sort', 'desc') === 'asc' && $story->getNextSibling())
                        <!-- Upper arm -->
                        <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-300 dark:text-gray-600"></path>
                    @endif
                </svg>
            </div>

            <div class="col-start-2 col-span-11 ml-0">
                <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ $story->title }}</h3>

                <p class="leading-7 mt-1">{{ $story->description }}</p>

                <div class="relative flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-8 mt-3 text-base md:text-sm">
                    <span>
                        <x-badge :color="$story->status->color()">
                            {{ $story->status->displayName() }}
                        </x-badge>
                    </span>

                    @if ($story->postCount > 0)
                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ number_format($story->postCount) }} @choice('post|posts', $story->postCount)</span>
                    @endif

                    @if ($story->getDescendantCount() > 0)
                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ number_format($story->all_stories_post_count) }} posts in all stories</span>
                    @endif

                    @canany(['view', 'create', 'update', 'delete'], $story)
                        <span class="leading-0">
                            <x-button
                                size="none"
                                color="gray-primary-text"
                                leading="settings"
                                wire:click="selectStory('{{ $story->id }}')"
                            >
                                Manage
                            </x-button>
                        </span>
                    @endcanany

                    @can('view', $story)
                        <span class="leading-0">
                            <x-link :href="route('stories.show', $story)" size="none" color="gray-primary-text" leading="arrow-right">
                                Go to story
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
