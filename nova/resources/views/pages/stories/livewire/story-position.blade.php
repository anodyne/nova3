<div class="space-y-8">
    <x-input.group label="Parent story" for="parent_id">
        <x-slot name="help">
            @if (isset($parent) && $parent->stories_count === 0)
                    This would be the first story nested inside {{ $parent->title }}. Because of this, the status of
                    {{ $parent->title }} will be set to Completed. You can manually update {{ $parent->title }}'s
                    status to Current if you'd like players to be able to write posts in {{ $parent->title }}.
            @endif
        </x-slot>

        <x-input.select name="parent_id" id="parent_id" wire:model.number="parentId">
            <option value="">No parent story</option>
            @foreach ($parentStories as $parentStory)
                <option value="{{ $parentStory->id }}">{{ $parentStory->title }}</option>
            @endforeach
        </x-input.select>
    </x-input.group>

    <x-input.group label="Display order" for="display_neighbor">
        @if ($storiesForOrdering->count() > 0)
            <x-input.field>
                <x-slot name="leading">
                    <select
                        name="display_direction"
                        id="display_direction"
                        aria-label="Display Order"
                        class="form-select -ml-3 h-full border-none bg-transparent py-0 text-gray-500 focus:shadow-none focus:outline-none focus:ring-0 sm:text-sm"
                        wire:model="direction"
                    >
                        <option value="before">Before</option>
                        <option value="after">After</option>
                    </select>
                </x-slot>

                <select
                    name="display_neighbor"
                    id="display_neighbor"
                    class="form-select h-full w-full border-none bg-transparent p-0 focus:shadow-none focus:outline-none focus:ring-0"
                    wire:model="neighborId"
                >
                    @foreach ($storiesForOrdering as $orderStory)
                        <option value="{{ $orderStory->id }}">{{ $orderStory->title }}</option>
                    @endforeach
                </select>
            </x-input.field>
        @else
            <div class="flex items-center font-medium text-warning-600">
                <x-icon name="warning" size="md" class="mr-3 shrink-0 text-warning-500"></x-icon>
                <span>There are no stories available for setting display order.</span>
            </div>
        @endif
    </x-input.group>

    <input type="hidden" name="has_position_change" value="{{ $hasPositionChange ? '1' : '0' }}" />
</div>
