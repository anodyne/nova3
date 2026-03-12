@use('Nova\Stories\Models\Story')

<div>
    @if ($stories->count() > 0)
        <x-spacing>
            <div class="flex items-center gap-8">
                <x-input.group class="max-w-fit">
                    <x-select wire:model.live="sortField" class="max-w-fit">
                        <option value="order_column">Sort by timeline order</option>
                        <option value="started_at">Sort by start date</option>
                        <option value="ended_at">Sort by end date</option>
                    </x-select>

                    <x-select wire:model.live="sortDirection" class="max-w-fit">
                        <option value="desc">Newest first</option>
                        <option value="asc">Oldest first</option>
                    </x-select>
                </x-input.group>

                @can('viewAny', Story::class)
                    <x-button :href="route('admin.stories.index')">
                        <x-icon :name="Tabler::Settings" size="sm" />
                        Manage stories
                    </x-button>
                @endcan
            </div>

            <div class="mt-12">
                <x-stories.timeline :stories="$stories" wire:key="{{ $sortDirection }}" />
            </div>
        </x-spacing>
    @else
        <x-empty variant="jumbo">
            <x-illustration :name="Illustration::Book" />
            <x-empty.heading>No stories found</x-empty.heading>

            @can('create', Story::class)
                <x-button :href="route('admin.stories.create')" variant="primary">Add your first story</x-button>
            @endcan
        </x-empty>
    @endif
</div>
