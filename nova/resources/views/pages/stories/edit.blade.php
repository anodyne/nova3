@extends($meta->template)

@section('content')
    <x-page-header :title="$story->title">
        <x-slot:pretitle>
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('stories.update', $story)" method="PUT">
            <x-form.section title="Story Info" message="Provide some basic information about your story including a brief description of what the story is about.">
                <x-input.group label="Title" for="title" :error="$errors->first('title')">
                    <x-input.text id="title" name="title" data-cy="title" :value="old('title', $story->title)" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="10">{{ old('description', $story->description) }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Status & Dates" message="Setting the status of a story lets you control the stories that players are able to write within. You can have as many currently running stories as you want. If you have more than 1 current story, players will be given the option to choose which story they want to write their post within.">
                <x-input.group label="Status">
                    <x-input.select name="status" id="status">
                        @foreach (Nova\Stories\Models\Story::getStatesFor('status') as $status)
                            <option value="{{ $status }}" @if (old('status', $story->status->name()) === $status) selected @endif>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Start Date" for="start_date">
                    <x-input.date
                        name="start_date"
                        id="start_date"
                        placeholder="Select a start date"
                        :value="old('start_date', $story->start_date->format('Y-m-d') ?? '')"
                    ></x-input.date>
                </x-input.group>

                <x-input.group label="End Date" for="end_date">
                    <x-input.date
                        name="end_date"
                        id="end_date"
                        placeholder="Select an end date"
                        :value="old('end_date', $story->end_date ?? '')"
                    ></x-input.date>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Hierarchy" message="Stories can be organized inside any story on the timeline and then ordered within the parent story in whatever order you'd like.">
                @livewire('stories:hierarchy', [
                    'parentId' => old('parent_id', $story->parent_id),
                    'direction' => old('direction', request()->direction ?? 'after'),
                    'neighbor' => old('neighbor', request()->neighbor),
                    'story' => $story,
                ])
            </x-form.section>

            <x-form.section title="Story Image" message="The story image should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 5MB in size.">
                @livewire('upload-image')
            </x-form.section>

            <x-form.section>
                <x-input.group label="Story Summary">
                    <livewire:nova:editor :content="old('summary', $story->summary ?? '')" fieldName="summary" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Update Story</x-button>
                <x-link :href="route('stories.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
