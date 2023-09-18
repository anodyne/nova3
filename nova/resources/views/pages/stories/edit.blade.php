@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit story">
            <x-slot name="actions">
                @can('viewAny', Nova\Stories\Models\Story::class)
                    <x-button.text :href="route('stories.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('stories.update', $story)" method="PUT">
            <x-form.section
                title="Story info"
                message="Provide some basic information about your story including a brief description of what the story is about."
            >
                <x-input.group label="Title" for="title" :error="$errors->first('title')">
                    <x-input.text id="title" name="title" data-cy="title" :value="old('title', $story->title)" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="10">
                        {{ old('description', $story->description) }}
                    </x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Story status"
                message="Setting the status of a story lets you control the stories that players are able to write within. You can have as many currently running stories as you want. If you have more than 1 current story, players will be given the option to choose which story they want to write their post within."
            >
                <fieldset>
                    <legend class="sr-only">Status</legend>
                    <div class="space-y-4">
                        @foreach (Nova\Stories\Models\Story::getStatuses() as $status)
                            <x-input.radio
                                id="{{ $status->name() }}"
                                aria-describedby="{{ $status->name() }}-description"
                                name="status"
                                value="{{ $status->name() }}"
                                :checked="old('status', $story->status->name()) === $status->name()"
                                :label="$status->displayName()"
                                :help="$status->description()"
                            ></x-input.radio>
                        @endforeach
                    </div>
                </fieldset>
            </x-form.section>

            <x-form.section
                title="Story hierarchy"
                message="Stories can be organized inside any story on the timeline and then ordered within the parent story in whatever order you'd like."
            >
                <livewire:stories-hierarchy
                    :parent-id="old('parent_id', $story->parent_id)"
                    :direction="old('direction', request('direction', 'after'))"
                    :neighbor="old('neghbor', request('neighbor'))"
                    :story="$story"
                />
            </x-form.section>

            <x-form.section
                title="Story image"
                message="The story image should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 10MB in size."
            >
                @livewire('media:upload-image')
            </x-form.section>

            <x-form.section>
                <x-input.group label="Story summary">
                    <livewire:nova:editor :content="old('summary', $story->summary ?? '')" fieldName="summary" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('stories.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
