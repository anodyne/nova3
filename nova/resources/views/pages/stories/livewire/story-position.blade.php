<div class="space-y-8">
    <x-select label="Parent story" name="parent_id" wire:model.number.live="parentId">
        <option value="">No parent story</option>
        @foreach ($parentStories as $pStory)
            <option value="{{ $pStory->id }}">{{ $pStory->title }}</option>
        @endforeach
    </x-select>

    @if ($storiesForOrdering->count() > 0)
        @if ($storiesForOrdering->count() === 1 && $storiesForOrdering->first()->is($story))
            <x-input.display label="Display order">
                <x-text>This is the only story in {{ $parentStory?->title }}.</x-text>
            </x-input.display>
        @else
            <x-field>
                <x-label>Position</x-label>

                <x-input.group>
                    <x-select name="display_direction" wire:model.live="direction" class="max-w-fit">
                        <option value="before">Before</option>
                        <option value="after">After</option>
                    </x-select>

                    <x-select name="display_neighbor" wire:model.live="neighborId">
                        @foreach ($storiesForOrdering as $orderStory)
                            <option value="{{ $orderStory->id }}">{{ $orderStory->title }}</option>
                        @endforeach
                    </x-select>
                </x-input.group>
            </x-field>
        @endif
    @else
        <x-input.display label="Display order">
            <x-text>This will be the first story nested within {{ $parentStory?->title }}.</x-text>
        </x-input.display>
    @endif

    <input type="hidden" name="has_position_change" value="{{ $hasPositionChange ? '1' : '0' }}" />
</div>
