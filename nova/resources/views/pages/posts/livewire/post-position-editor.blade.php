@use('Nova\Stories\Enums\PositionDirection')

<x-modal.slide-over
    title="Update post position"
    description="Posts live on a timeline which allows you to set exactly where this post should appear in the story’s timeline."
    :icon="Tabler::TimelineEvent"
>
    <x-radio.group wire:model.live="direction">
        <x-radio
            value="after"
            label="Custom position"
            description="Choose which post your post will appear near in the story"
        />
        <x-radio
            value="start"
            label="Start of the story"
            description="Your post will appear as the first post in the story"
        />
        <x-radio
            value="end"
            label="End of the story"
            description="Your post will appear as the last post in the story"
        />
    </x-radio.group>

    @if ($direction === PositionDirection::After)
        <x-panel.manage.search :$search placeholder="Find a post in the current story">
            @if ($searchResults->count() === 0)
                <x-empty variant="compact">
                    <x-icon :name="Tabler::Book2" />
                    <x-empty.heading>No posts found</x-empty.heading>
                </x-empty>
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

                <x-field>
                    <x-label>Move this post</x-label>

                    <x-radio.group wire:model.live="direction" variant="segmented">
                        <x-radio :value="PositionDirection::Before->value" label="Before this post" />
                        <x-radio :value="PositionDirection::After->value" label="After this post" />
                    </x-radio.group>
                </x-field>
            </div>
        @endif
    @endif

    <x-slot name="footer">
        <x-button type="button" wire:click="save" variant="primary">Update</x-button>
        <x-button type="button" wire:click="$dispatch('slide-over.close')" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
