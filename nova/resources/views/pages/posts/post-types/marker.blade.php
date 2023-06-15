<div class="block bg-gray-50">
    <div class="relative flex items-center px-4 py-4 sm:px-6">
        <div class="absolute right-0 top-0 pr-4 pt-4 sm:pr-6">
            <x-dropdown placement="bottom-end">
                <x-slot name="trigger">
                    <x-icon.more class="h-6 w-6" />
                </x-slot>

                <x-dropdown.group>
                    <x-dropdown.item icon="show" data-cy="view">
                        <span>View</span>
                    </x-dropdown.item>

                    @can('update', $post)
                        <x-dropdown.item icon="edit" data-cy="edit">
                            <span>Edit</span>
                        </x-dropdown.item>
                    @endcan
                </x-dropdown.group>

                <x-dropdown.group>
                    <x-dropdown.text class="font-semibold uppercase tracking-wide text-gray-500">Add a post</x-dropdown.text>

                    <x-dropdown.item :href='route("posts.create", "direction=before&neighbor={$post->id}")' icon="move-up">
                        <span>Before this post</span>
                    </x-dropdown.item>
                    <x-dropdown.item :href='route("posts.create", "direction=after&neighbor={$post->id}")' icon="move-down">
                        <span>After this post</span>
                    </x-dropdown.item>
                </x-dropdown.group>

                @can('delete', $post)
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($post) }});" data-cy="delete">
                            <span>Delete</span>
                        </x-dropdown.item-danger>
                    </x-dropdown.group>
                @endcan
            </x-dropdown>
        </div>

        <div class="flex flex-1 flex-col items-center">
            <div class="flex w-full flex-1 flex-col items-center space-y-1">
                <div class="flex items-center space-x-2">
                    <span style="color: {{ $post->postType->color }}">
                        <x-icon :name="$post->postType->icon" size="md"></x-icon>
                    </span>
                    <div class="truncate text-xl font-bold tracking-tight text-gray-900">{{ $post->title }}</div>
                </div>

                @if ($post->day || $post->time || $post->location)
                    <div class="flex space-x-4">
                        @if ($post->location)
                            <div class="flex items-center space-x-1.5 text-sm text-gray-600">
                                <x-icon name="location" size="sm" class="shrink-0 text-gray-500"></x-icon>
                                <span>{{ $post->location }}</span>
                            </div>
                        @endif

                        @if ($post->day)
                            <div class="flex items-center space-x-1.5 text-sm text-gray-600">
                                <x-icon name="calendar" size="sm" class="shrink-0 text-gray-500"></x-icon>
                                <span>{{ $post->day }}</span>
                            </div>
                        @endif

                        @if ($post->time)
                            <div class="flex items-center space-x-1.5 text-sm text-gray-600">
                                <x-icon name="clock" size="sm" class="shrink-0 text-gray-500"></x-icon>
                                <span>{{ $post->time }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="prose prose-sm max-w-full text-gray-900">{!! $post->content !!}</div>
            </div>
        </div>
    </div>
</div>
