<div
    class="group hover:bg-primary-600 dark:hover:bg-primary-500 relative flex cursor-default items-center px-4 py-2 select-none hover:text-white focus:outline-hidden"
>
    <a href="{{ route('admin.announcements.show', $result) }}" class="absolute inset-0"></a>

    <h3 class="font-medium">{{ $result->title }}</h3>
</div>
