<x-form :action="route('post-types.destroy', $postType)" method="DELETE" id="form" :divide="false">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $postType->name }}</span> post type? Users will no longer be able to create story posts with this post type.</p>
</x-form>
