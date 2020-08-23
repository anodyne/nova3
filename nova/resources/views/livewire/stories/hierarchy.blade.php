<div>
    <x-input.group label="Parent Story" for="parent_id">
        <select name="parent_id" id="parent_id" class="form-select" wire:model="parentId">
            @foreach ($parentStories as $parentStory)
                <option value="{{ $parentStory->id }}">{{ $parentStory->title }}</option>
            @endforeach
        </select>
    </x-input.group>

    <x-input.group label="Display Order" for="display_story">
        @if ($orderStories->count() > 0)
            <x-input.field>
                <x-slot name="leadingAddOn">
                    <select name="display_direction" id="display_direction" aria-label="Display Order" class="form-select h-full py-0 border-transparent bg-transparent text-gray-500 -ml-3 focus:outline-none | sm:text-sm" wire:model="direction">
                        <option value="before" @if (request()->has('before')) selected @endif>Before</option>
                        <option value="after" @if (request()->has('after')) selected @endif>After</option>
                    </select>
                </x-slot>

                <select name="display_story" id="display_story" class="form-select h-full w-full py-0 border-transparent bg-transparent focus:outline-none" wire:model="neighbor">
                    @foreach ($orderStories as $orderStory)
                        <option value="{{ $orderStory->id }}" @if (request()->before == $orderStory->id || request()->after == $orderStory->id) selected @endif>{{ $orderStory->title }}</option>
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
</div>