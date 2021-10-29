@props([
    'stories'
])

<div>
    @foreach ($stories as $story)
        <div class="grid md:grid-cols-12 items-baseline relative p-3 sm:p-5 overflow-hidden" wire:key="story-{{ $story->id }}">
            <div class="md:col-start-1 md:col-span-1 row-start-1 md:row-end-3 flex items-center font-medium mb-1 md:mb-0">
                <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible">
                    <!-- Circle -->
                    <circle cx="6" cy="6" r="6" fill="currentColor" class="text-{{ $story->status->color() }}-9"></circle>

                    @if ($story->is_current)
                        <!-- Ring -->
                        <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-9"></circle>
                    @endif

                    @if ($story->getNextSibling())
                        <!-- Lower arm -->
                        <path d="M 6 18 V 50000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                    @endif

                    @if ($story->getPrevSibling())
                        <!-- Upper arm -->
                        <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-6"></path>
                    @endif
                </svg>
            </div>

            <div class="md:col-start-2 md:col-span-11 ml-9 md:ml-0 text-gray-11">
                <h3 class="text-xl font-bold tracking-tight text-gray-12">{{ $story->title }}</h3>

                <p class="leading-7 mt-1">{{ $story->description }}</p>

                <div class="relative flex items-center space-x-8 mt-3 text-sm text-gray-11">
                    <x-badge :color="$story->status->color()" size="xs">
                        {{ $story->status->displayName() }}
                    </x-badge>

                    <span>{{ $story->posts()->count() }} @choice('post|posts', $story->posts()->count())</span>

                    @if ($story->getDescendantCount() > 0)
                        <span>{{ mt_rand(500, 800) }} posts in all stories</span>
                    @endif

                    <x-button type="button" size="none" color="gray-text" wire:click="selectStory('{{ $story->id }}')">
                        @icon('settings', 'h-5 w-5 flex-shrink-0')
                        <span>Manage story</span>
                    </x-button>
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