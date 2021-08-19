@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Story">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('stories.store')">
            <x-form.section title="Story Info" message="Provide some basic information about your story including a brief description of what the story is about.">
                <x-input.group label="Title" for="title" :error="$errors->first('title')">
                    <x-input.text id="title" name="title" data-cy="title" :value="old('title')" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="10">{{ old('description') }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Status & Dates" message="Setting the status of a story lets you control the stories that players are able to write within. You can have as many currently running stories as you want. If you have more than 1 current story, players will be given the option to choose which story they want to write their post within.">
                <x-input.group label="Status">
                    <x-input.select name="status" id="status">
                        @foreach (['upcoming', 'current', 'completed'] as $status)
                            <option value="{{ $status }}" @if (old('status') === $status) selected @endif>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="allow_posting" :value="old('allow_posting', 'true')">
                        Users can add posts to this story
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Start Date" for="start_date">
                    <x-input.field>
                        <x-slot name="leadingAddOn">@icon('calendar')</x-slot>

                        <x-buk-pikaday name="start_date" id="start_date" format="YYYY-MM-DD" :value="old('start_date', '')" class="form-field w-full | md:w-1/2" />
                    </x-input.field>
                </x-input.group>

                <x-input.group label="End Date" for="end_date">
                    <x-input.field>
                        <x-slot name="leadingAddOn">@icon('calendar')</x-slot>

                        <x-buk-pikaday name="end_date" id="end_date" format="YYYY-MM-DD" :value="old('end_date', '')" class="form-field" />
                    </x-input.field>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Hierarchy" message="Stories can be organized inside any story on the timeline and then ordered within the parent story in whatever order you'd like.">
                @livewire('stories:hierarchy', [
                    'parentId' => old('parent_id', request()->parent ?? 1),
                    'direction' => old('direction', request()->direction ?? 'after'),
                    'neighbor' => old('neighbor', request()->neighbor),
                    'hasPositionChange' => true,
                ])
            </x-form.section>

            <x-form.section title="Story Image" message="The story image should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 5MB in size.">
                @livewire('upload-image')
            </x-form.section>

            <x-form.section>
                <x-input.group label="Story Summary">
                    <x-input.rich-text name="summary" :initial-value="old('summary')" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add Story</x-button>
                <x-link :href="route('stories.index')" type="button" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
