@use('Nova\Stories\Models\Story')

<div>
    @if ($stories->count() > 0)
        <x-spacing>
            <div class="flex items-center gap-x-8">
                <div class="flex items-center">
                    <x-input.field>
                        <x-slot name="leading">
                            <select
                                aria-label="Story sort field"
                                class="form-select -ml-3 h-full border-none bg-transparent py-0 text-gray-900 focus:shadow-none focus:outline-none focus:ring-0 dark:text-white sm:text-sm"
                                wire:model.live="sortField"
                            >
                                <option value="order_column">Sort by timeline order</option>
                                <option value="started_at">Sort by start date</option>
                                <option value="ended_at">Sort by end date</option>
                            </select>
                        </x-slot>

                        <select
                            aria-label="Story sort direction"
                            class="form-select -ml-3 h-full border-none bg-transparent py-0 text-gray-900 focus:shadow-none focus:outline-none focus:ring-0 dark:text-white sm:text-sm"
                            wire:model.live="sortDirection"
                        >
                            <option value="desc">Newest first</option>
                            <option value="asc">Oldest first</option>
                        </select>
                    </x-input.field>
                </div>

                @can('viewAny', Story::class)
                    <div class="flex items-center">
                        <x-button :href="route('admin.stories.index')" color="primary">
                            <x-icon name="settings" size="sm"></x-icon>
                            Manage stories
                        </x-button>
                    </div>
                @endcan
            </div>

            <div class="mt-12">
                <x-stories.timeline :stories="$stories" wire:key="{{ $sortDirection }}" />
            </div>
        </x-spacing>
    @else
        <x-empty-state variant="jumbo">
            <x-icon name="book"></x-icon>
            <x-h2>No stories found</x-h2>

            @can('create', Story::class)
                <x-button :href="route('admin.stories.create')" color="primary">Add your first story</x-button>
            @endcan
        </x-empty-state>
    @endif
</div>
