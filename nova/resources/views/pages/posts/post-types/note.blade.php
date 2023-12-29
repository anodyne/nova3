<div>
    <div class="flex cursor-pointer items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <x-h2>{{ $post->title }}</x-h2>
        </div>
    </div>
    <div class="mt-3 flex-1">
        <x-content-box width="none" height="none" class="mb-6 flex flex-col gap-6">
            <div class="flex-1">
                <div
                    class="relative mt-2 flex flex-col space-y-3 text-base md:flex-row md:items-center md:space-x-8 md:space-y-0 md:text-sm"
                >
                    @if ($post->postType->fields->location->enabled && filled($post->location))
                        <div class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400">
                            <div class="text-gray-400 dark:text-gray-500">
                                <x-icon name="location"></x-icon>
                            </div>
                            <div>{{ $post->location }}</div>
                        </div>
                    @endif

                    @if ($post->postType->fields->day->enabled && filled($post->day))
                        <div class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400">
                            <div class="text-gray-400 dark:text-gray-500">
                                <x-icon name="calendar"></x-icon>
                            </div>
                            <div>{{ $post->day }}</div>
                        </div>
                    @endif

                    @if ($post->postType->fields->time->enabled && filled($post->time))
                        <div class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400">
                            <div class="text-gray-400 dark:text-gray-500">
                                <x-icon name="clock"></x-icon>
                            </div>
                            <div>{{ $post->time }}</div>
                        </div>
                    @endif

                    <div class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400">
                        <div class="text-gray-400 dark:text-gray-500">
                            <x-icon :name="$post->postType->icon"></x-icon>
                        </div>
                        <div>{{ $post->postType->name }}</div>
                    </div>

                    <x-button :href="route('posts.show', ['story' => $post->story, 'post' => $post])" outline>
                        Read post &rarr;
                    </x-button>
                </div>

                <div class="relative mt-4">
                    <div class="flex -space-x-2 overflow-hidden">
                        <img
                            class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt=""
                        />
                        <img
                            class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt=""
                        />
                        <img
                            class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80"
                            alt=""
                        />
                        <img
                            class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt=""
                        />
                    </div>
                </div>

                <div class="prose prose-lg relative mt-4 max-w-none dark:prose-invert">
                    {!! $post->content !!}
                </div>
            </div>
        </x-content-box>
    </div>
</div>
