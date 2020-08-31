<div class="space-y-8">
    <x-input.group label="Parent Story" for="parent_id">
        <x-input.select name="parent_id" id="parent_id" wire:model="parentId">
            @foreach ($parentStories as $parentStory)
                <option value="{{ $parentStory->id }}">{{ $parentStory->title }}</option>
            @endforeach
        </x-input.select>
    </x-input.group>

    <x-input.group label="Display Order" for="display_neighbor">
        @if ($orderStories->count() > 0)
            <x-input.field>
                <x-slot name="leadingAddOn">
                    <select name="display_direction" id="display_direction" aria-label="Display Order" class="form-select h-full py-0 border-none bg-transparent text-gray-500 -ml-3 focus:outline-none focus:shadow-none | sm:text-sm" wire:model="direction">
                        <option value="before">Before</option>
                        <option value="after">After</option>
                    </select>
                </x-slot>

                <select name="display_neighbor" id="display_neighbor" class="form-select h-full w-full py-0 border-none bg-transparent focus:outline-none focus:shadow-none" wire:model="neighbor">
                    @foreach ($orderStories as $orderStory)
                        <option value="{{ $orderStory->id }}">{{ $orderStory->title }}</option>
                    @endforeach
                </select>
            </x-input.field>
        @else
            <div class="flex items-center font-medium text-warning-600">
                @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6 text-warning-400')
                <span>There are no stories available for setting display order.</span>
            </div>
        @endif
    </x-input.group>

    <input type="hidden" name="has_position_change" value="{{ $hasPositionChange ? '1' : '0' }}">
</div>
