<x-modal.bare :size-class="$this->sizeClass()">
    <x-panel variant="well" class="transform shadow-2xl">
        <x-panel>
            <div class="grid grid-cols-[auto_1fr_auto] px-4">
                <x-icon
                    :name="Tabler::Search"
                    size="sm"
                    class="pointer-events-none mr-2.5 self-center text-gray-400 dark:text-gray-500"
                />
    
                <input
                    type="text"
                    autofocus
                    placeholder="Search..."
                    wire:model.live.debounce="search"
                    class="h-12 w-full text-base text-gray-900 outline-hidden placeholder:text-gray-400 sm:text-sm dark:bg-gray-950 dark:text-white dark:placeholder:text-gray-500"
                />
    
                @if (filled($search))
                    <x-button
                        type="button"
                        class="ml-4 self-center"
                        wire:click="$set('search', '')"
                        icon="x-mark"
                        size="sm"
                        variant="subtle"
                        inset="right top bottom"
                        square
                    />
                @endif
            </div>
    
            @if (filled($search))
                @if ($numberOfResults > 0)
                    <!-- Results, show/hide based on command palette state -->
                    <div
                        class="flex max-h-96 transform-gpu scroll-py-10 scroll-pb-2 flex-col gap-4 overflow-y-auto p-4 pb-2"
                    >
                        @foreach ($results as $model => $modelResults)
                            @if ($modelResults->count() > 0)
                                <div>
                                    <h2
                                        class="flex items-center justify-between gap-3 text-xs font-semibold text-gray-900 dark:text-white"
                                    >
                                        <span>
                                            {{ $model }}
                                        </span>
                                        <span class="font-normal text-gray-500 dark:text-gray-400">
                                            {{ str('result')->plural($modelResults->count())->prepend($modelResults->count().' ') }}
                                        </span>
                                    </h2>
                                    <div class="-mx-4 mt-2 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach ($modelResults as $result)
                                            @includeWhen($model === 'Announcements', 'livewire.search.announcements', ['result' => $result])
                                            @includeWhen($model === 'Characters', 'livewire.search.characters', ['result' => $result])
                                            @includeWhen($model === 'Stories', 'livewire.search.stories', ['result' => $result])
                                            @includeWhen($model === 'Story posts', 'livewire.search.story-posts', ['result' => $result])
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <!-- Empty state, show/hide based on command palette state -->
                    <div>
                        <x-empty>
                            <x-icon :name="Tabler::MoodSad"/>
                            <x-empty.heading>No results found</x-empty.heading>
                            <x-empty.text>We couldn’t find anything with that term. Please try again.</x-empty.text>
                        </x-empty>
                    </div>
                @endif
            @endif
        </x-panel>
    
        <x-panel.footer class="flex flex-wrap items-center gap-2 text-xs" size="row-sm">
            <p class="font-medium">Show results for:</p>
    
            <x-checkbox.group wire:model.live="categories" variant="pills">
                <x-checkbox class="text-xs" value="announcements" label="Announcements"/>
                <x-checkbox class="text-xs" value="characters" label="Characters"/>
                <x-checkbox class="text-xs" value="stories" label="Stories"/>
                <x-checkbox class="text-xs" value="posts" label="Story posts"/>
            </x-checkbox.group>
        </x-panel.footer>
    </x-panel>
</x-modal.bare>
