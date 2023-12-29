@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new story">
            <x-slot name="actions">
                @can('viewAny', Nova\Stories\Models\Story::class)
                    <x-button :href="route('stories.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('stories.store')">
            <x-form.section
                title="Story info"
                message="Provide some basic information about your story including a brief description of what the story is about."
            >
                <x-input.group label="Title" for="title" :error="$errors->first('title')">
                    <x-input.text id="title" name="title" data-cy="title" :value="old('title')" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="10">
                        {{ old('description') }}
                    </x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story status">
                <x-slot name="message">
                    <x-text>
                        Setting the status of a story lets you control the stories that players are able to write
                        within. You can have as many currently running stories as you want. If you have more than 1
                        current story, players will be given the option to choose which story they want to write their
                        post within.
                    </x-text>
                </x-slot>

                <x-radio.group>
                    @foreach (Nova\Stories\Models\Story::getStatuses() as $status)
                        <x-radio.field>
                            <x-fieldset.label :for="$status->name()">
                                {{ $status->displayName() }}
                            </x-fieldset.label>
                            <x-fieldset.description>{{ $status->description() }}</x-fieldset.description>
                            <x-radio
                                name="status"
                                :id="$status->name()"
                                :value="$status->name()"
                                :checked="old('status', 'upcoming') === $status->name()"
                            ></x-radio>
                        </x-radio.field>
                    @endforeach
                </x-radio.group>
            </x-form.section>

            <x-form.section
                title="Story position"
                message="Stories can be organized inside any story on the timeline and then ordered within the parent story in whatever order you'd like."
            >
                <livewire:stories-position
                    :parent-id="old('parent_id', request('parent'))"
                    :direction="old('direction', request('direction', 'after'))"
                    :neighbor-id="old('neighbor', request('neighbor'))"
                    :has-position-change="true"
                />
            </x-form.section>

            <x-form.section
                title="Story image"
                message="The story image should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 10MB in size."
            >
                <livewire:media-upload-image />
            </x-form.section>

            <x-form.section>
                <x-input.group label="Story summary">
                    <x-editor :value="old('summary', '')" field-name="summary"></x-editor>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('stories.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
