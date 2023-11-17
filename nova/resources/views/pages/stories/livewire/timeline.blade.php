@if ($stories->count() > 0)
    <x-content-box width="lg">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-1">
                <x-button.text
                    :color="$sort === 'latest' ? 'subtle-neutral' : 'primary'"
                    wire:click="$set('sort', 'oldest')"
                >
                    <x-icon name="sort-descending" size="md"></x-icon>
                </x-button.text>

                <x-button.text
                    :color="$sort === 'oldest' ? 'subtle-neutral' : 'primary'"
                    wire:click="$set('sort', 'latest')"
                >
                    <x-icon name="sort-ascending" size="md"></x-icon>
                </x-button.text>
            </div>

            @can('viewAny', $storyClass)
                <x-button.filled :href="route('stories.index')" leading="settings" color="primary">
                    Manage stories
                </x-button.filled>
            @endcan
        </div>

        <x-stories.timeline :stories="$stories" />
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
