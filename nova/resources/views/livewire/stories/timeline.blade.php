<x-panel>
    <x-panel.header title="Stories" message="Manage the stories and timeline of your game">
        <x-slot name="actions">
            <div class="flex items-center gap-1">
                <x-button.text
                    :color="$sort === 'latest' ? 'light-gray' : 'primary'"
                    wire:click="$set('sort', 'oldest')"
                >
                    <x-icon name="sort-descending" size="md"></x-icon>
                </x-button.text>

                <x-button.text
                    :color="$sort === 'oldest' ? 'light-gray' : 'primary'"
                    wire:click="$set('sort', 'latest')"
                >
                    <x-icon name="sort-ascending" size="md"></x-icon>
                </x-button.text>
            </div>

            @can('create', $storyClass)
                <x-button.filled :href="route('stories.create')" leading="add" color="primary">Add</x-button.filled>
            @endcan
        </x-slot>
    </x-panel.header>

    <x-content-box width="lg">
        <x-stories.timeline :stories="$stories" />
    </x-content-box>
</x-panel>
