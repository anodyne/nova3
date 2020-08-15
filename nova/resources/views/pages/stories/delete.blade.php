<x-form :action="route('stories.destroy', $story)" method="DELETE" id="form">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $story->title }}</span> story?</p>

    <div class="text-left mt-8" x-data="{ deletePosts: true, deleteStories: true }">
        <div>
            <x-input.checkbox
                label="Delete all stories inside this story?"
                for="delete_stories"
                name="delete_stories"
                id="delete_stories"
                x-model="deleteStories"
            />
        </div>

        <div class="mt-4" x-show="!deleteStories">
            <x-input.checkbox
                label="Delete all posts in this story?"
                for="delete_posts"
                name="delete_posts"
                id="delete_posts"
                x-model="deletePosts"
            />
        </div>

        <div class="mt-4" x-show="!deletePosts">
            <x-input.group label="Move all posts from this story to:">
                <select name="posts_new_story" id="posts_new_story" class="form-select">
                    @foreach ($stories as $newStory)
                        <option value="{{ $newStory->id }}">{{ $newStory->title }}</option>
                    @endforeach
                </select>
            </x-input.group>
        </div>
    </div>
</x-form>
