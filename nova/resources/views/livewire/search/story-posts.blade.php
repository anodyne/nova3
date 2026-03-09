<div
    class="group hover:bg-primary-600 dark:hover:bg-primary-500 relative flex cursor-default items-center px-4 py-2 select-none hover:text-white focus:outline-hidden"
>
    <a
        href="{{ route('admin.posts.show', ['story' => $result->story, 'post' => $result]) }}"
        class="absolute inset-0"
    ></a>

    <div class="flex items-center gap-4">
        <h3 class="font-medium">{{ $result->title }}</h3>
        <p class="group-hover:text-primary-200 text-gray-500">
            {{ $result->story->title }}
        </p>
    </div>
</div>
