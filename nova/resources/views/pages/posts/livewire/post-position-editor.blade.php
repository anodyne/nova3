@use('Nova\Stories\Enums\PositionDirection')

<x-modal.slide-over
    title="Update post position"
    description="Posts live on a timeline which allows you to set exactly where this post should appear in the story’s timeline."
    :icon="Icon::Timeline"
>
    <flux:tab.group>
        <flux:tabs variant="pills">
            <flux:tab name="custom" wire:click="$set('direction', 'after')">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Icon::ArrowsSort" size="sm"></x-icon>
                    Custom position
                </div>
            </flux:tab>
            <flux:tab name="start" wire:click="$set('direction', 'start')">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Icon::ArrowVerticalStart" size="sm"></x-icon>
                    Start of the story
                </div>
            </flux:tab>
            <flux:tab name="end" wire:click="$set('direction', 'end')">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Icon::ArrowVerticalEnd" size="sm"></x-icon>
                    End of the story
                </div>
            </flux:tab>
        </flux:tabs>

        <flux:tab.panel name="start">
            <x-panel.primary
                title="Move to start"
                description="Your post will appear as the first post in the story."
                :icon="Icon::ArrowVerticalStart"
            ></x-panel.primary>
        </flux:tab.panel>

        <flux:tab.panel name="end">
            <x-panel.primary
                title="Move to end"
                description="Your post will appear as the last post in the story."
                :icon="Icon::ArrowVerticalEnd"
            ></x-panel.primary>
        </flux:tab.panel>

        <flux:tab.panel name="custom" class="space-y-6">
            <x-panel.manage.search :$search placeholder="Find a post in the current story">
                @if ($searchResults->count() === 0)
                    <x-empty-state.small :icon="Icon::BookClosed" title="No post(s) found"></x-empty-state.small>
                @else
                    <x-dropdown.group>
                        @foreach ($searchResults as $post)
                            <x-panel.manage.result-item
                                :value="$post->id"
                                :text="$post->title"
                            ></x-panel.manage.result-item>
                        @endforeach
                    </x-dropdown.group>
                @endif
            </x-panel.manage.search>

            @if ($neighbor)
                <div class="space-y-3">
                    <div>
                        <x-h2>{{ $neighbor?->title }}</x-h2>
                        <x-text><em>{{ $neighbor?->location_day_time }}</em></x-text>
                    </div>

                    <x-text size="lg">{{ $neighbor?->authors_string }}</x-text>

                    <x-fieldset.field id="move" name="move" label="Move this post">
                        <flux:radio.group wire:model.live="direction" variant="segmented" data-slot="control">
                            <flux:radio :value="PositionDirection::Before->value" label="Before this post" />
                            <flux:radio :value="PositionDirection::After->value" label="After this post" />
                        </flux:radio.group>
                    </x-fieldset.field>
                </div>
            @endif
        </flux:tab.panel>
    </flux:tab.group>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
        <x-button type="button" wire:click="$dispatch('slide-over.close')" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
