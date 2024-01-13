<div class="space-y-8">
    <x-fieldset.field label="Parent story" name="parent_id" id="parent_id">
        <x-select wire:model.number.live="parentId">
            <option value="">No parent story</option>
            @foreach ($parentStories as $pStory)
                <option value="{{ $pStory->id }}">{{ $pStory->title }}</option>
            @endforeach
        </x-select>
    </x-fieldset.field>

    @if ($storiesForOrdering->count() > 0)
        <x-fieldset.field label="Display order" name="display_direction" id="display_direction">
            <x-select aria-label="Display order" wire:model.live="direction">
                <option value="before">Before</option>
                <option value="after">After</option>
            </x-select>
        </x-fieldset.field>

        <x-fieldset.field label="Display neighbor" name="display_neighbor" id="display_neighbor">
            <x-select wire:model.live="neighborId">
                @foreach ($storiesForOrdering as $orderStory)
                    <option value="{{ $orderStory->id }}">{{ $orderStory->title }}</option>
                @endforeach
            </x-select>
        </x-fieldset.field>
    @else
        <x-fieldset.field id="no_stories" name="no_stories" label="Display order">
            <x-slot name="description">This will be the first story nested within {{ $parentStory?->title }}.</x-slot>
        </x-fieldset.field>
    @endif

    <input type="hidden" name="has_position_change" value="{{ $hasPositionChange ? '1' : '0' }}" />
</div>
