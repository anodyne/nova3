@if ($stories->count() > 0)
    <x-content-box width="lg">
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

            @can('viewAny', $storyClass)
                <div class="flex items-center">
                    <x-button.filled :href="route('stories.index')" leading="settings" color="primary">
                        Manage stories
                    </x-button.filled>
                </div>
            @endcan
        </div>

        <div class="mt-12">
            <x-stories.timeline :stories="$stories" />
        </div>
    </x-content-box>
@else
    <x-empty-state.large
        icon="book"
        title="No stories found"
        :link="route('stories.create')"
        label="Add your first story"
        :link-access="gate()->allows('create', $storyClass)"
    ></x-empty-state.large>
@endif
