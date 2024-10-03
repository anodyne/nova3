@use('Nova\Stories\Models\Story')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', $story::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.stories.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.stories.update', $story)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Title" id="title" name="title" :error="$errors->first('title')">
                        <x-input.text data-cy="title" :value="old('title', $story->title)" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Description" id="description" name="description">
                        <x-input.textarea data-cy="description" rows="10">
                            {{ old('description', $story->description) }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field label="Story image" id="story_image" name="story_image">
                        <livewire:media-upload-image :model="$story" media-collection-name="story-image" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="status-change"></x-icon>
                    <x-fieldset.legend>Story status</x-fieldset.legend>
                    <x-fieldset.description>
                        Setting the status of a story lets you control the stories that players are able to write
                        within. You can have as many currently running stories as you want. If you have more than 1
                        current story, players will be given the option to choose which story they want to write their
                        post within.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-radio.group>
                    @foreach (Story::getStatuses() as $status)
                        <x-radio.field id="status" name="status">
                            <x-fieldset.label :for="$status->name()">
                                {{ $status->displayName() }}
                            </x-fieldset.label>
                            <x-fieldset.description>{{ $status->description() }}</x-fieldset.description>

                            <x-radio
                                name="status"
                                :id="$status->name()"
                                :value="$status->name()"
                                :checked="old('status', $story->status->name()) === $status->name()"
                            ></x-radio>
                        </x-radio.field>
                    @endforeach
                </x-radio.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="timeline"></x-icon>
                    <x-fieldset.legend>Story position</x-fieldset.legend>
                    <x-fieldset.description>
                        Stories exist on a timeline for the game. This means you can organize them in just about any way
                        you want. You can position a story before or after another story or even nest it inside of a
                        story.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <livewire:stories-position
                        :parent-id="old('parent_id', $story->parent_id)"
                        :direction="old('direction', request('direction', 'after'))"
                        :neighbor-id="old('neghbor', request('neighbor'))"
                        :story="$story"
                    />
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field id="summary" name="summary" label="Story summary">
                        <x-editor :value="old('summary', $story->summary ?? '')" field-name="summary"></x-editor>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('admin.stories.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
