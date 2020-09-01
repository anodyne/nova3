<x-form :action="route('post-types.destroy', $postType)" method="DELETE" id="form" :divide="false">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $postType->name }}</span> post type?</p>

    <p class="mt-6">This action is permanent and cannot be undone. Users will not be able to create story posts with this post type.</p>
</x-form>
