@use('Nova\Stories\Models\Story')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Story::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.stories.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.stories.store')">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Title" name="title" :value="old('title')" />

                    <x-textarea label="Description" name="description">{{ old('description') }}</x-textarea>

                    <x-field>
                        <x-label>Story image</x-label>
                        <livewire:media-upload-image />
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::StatusChange" heading="Story status">
                    <x-description>
                        Setting the status of a story lets you control the stories that players are able to write
                        within. You can have as many currently running stories as you want. If you have more than 1
                        current story, players will be given the option to choose which story they want to write their
                        post within.
                    </x-description>
                </x-fieldset.heading>

                <x-radio.group name="status">
                    @foreach (Story::getStatuses() as $status)
                        <x-radio
                            :label="$status->getLabel()"
                            :description="$status->getDescription()"
                            :value="$status->name()"
                            :checked="old('status', 'upcoming') === $status->name()"
                        />
                    @endforeach
                </x-radio.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::TimelineEvent" heading="Story position">
                    <x-description>
                        Stories exist on a timeline for the game. This means you can organize them in just about any way
                        you want. You can position a story before or after another story or even nest it inside of a
                        story.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <livewire:stories-position
                        :parent-id="old('parent_id', request('parent'))"
                        :direction="old('direction', request('direction', 'after'))"
                        :neighbor-id="old('neighbor', request('neighbor'))"
                        :has-position-change="true"
                    />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.group>
                    <x-editor label="Story summary" name="summary" :value="old('summary')" />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.stories.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
