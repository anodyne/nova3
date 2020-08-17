@extends($__novaTemplate)

@section('content')
    <x-page-header title="Delete Story">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('stories.destroy', 1)" method="DELETE">
            @foreach ($storiesToDelete as $story)
                <x-form.section
                    :title="$story->title"
                    :message="$story->description"
                    x-data="{ storyAction: 'delete', postsAction: 'move' }"
                >
                    @if (! $loop->first)
                        <x-input.group>
                            <x-input.radio label="Delete this story" for="delete" name="story_action[{{ $story->id }}]" id="delete" value="delete" :checked="true" />

                            <span class="ml-6">
                                <x-input.radio label="Move this story" for="move" name="story_action[{{ $story->id }}]" id="move" value="move" />
                            </span>
                        </x-input.group>

                        <x-input.group label="Move this story to:">
                            <select name="" id="" class="form-select">
                                <option value="">Choose a story</option>
                            </select>
                        </x-input.group>
                    @endif

                    <x-input.group x-show="deleteStory">
                        <x-input.radio label="Delete this story's posts" for="delete" name="posts_action[{{ $story->id }}]" id="delete" value="delete" :checked="true" />

                        <span class="ml-6">
                            <x-input.radio label="Move this story's posts" for="move" name="posts_action[{{ $story->id }}]" id="move" value="move" />
                        </span>
                    </x-input.group>

                    <x-input.group label="Move this story's posts to:">
                        <select name="" id="" class="form-select">
                            <option value="">Choose a story</option>
                        </select>
                    </x-input.group>
                </x-form.section>
            @endforeach

            <x-form.footer>
                <button type="submit" class="button button-primary">Delete @choice('Story|Stories', $storiesToDelete)</button>

                <a href="{{ route('stories.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
