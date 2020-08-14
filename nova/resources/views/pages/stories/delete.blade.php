<x-form :action="route('stories.destroy', $story)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $story->title }} story?
</x-form>
