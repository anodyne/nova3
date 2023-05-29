<div class="block bg-gray-50">
    <div class="flex items-center relative px-4 py-4 sm:px-6">
        <div class="absolute top-0 right-0 pt-4 pr-4 sm:pr-6">
            <x-dropdown placement="bottom-end">
                <x-slot:trigger>
                    <x-icon.more class="h-6 w-6" />
                </x-slot:trigger>

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
                    <x-dropdown.text class="uppercase tracking-wide font-semibold text-gray-500">
                        Add a post
                    </x-dropdown.text>

                    <x-dropdown.item :href='route("posts.create", "direction=before&neighbor={$post->id}")' icon="move-up">
                        <span>Before this post</span>
                    </x-dropdown.item>
                    <x-dropdown.item :href='route("posts.create", "direction=after&neighbor={$post->id}")' icon="move-down">
                        <span>After this post</span>
                    </x-dropdown.item>
                </x-dropdown.group>

                @can('delete', $post)
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($post) }});" data-cy="delete">
                            <span>Delete</span>
                        </x-dropdown.item-danger>
                    </x-dropdown.group>
                @endcan
            </x-dropdown>
        </div>

        <div class="flex flex-col items-center flex-1">
            <div class="flex flex-col items-center flex-1 w-full space-y-1">
                <div class="flex items-center space-x-2">
                    <span style="color:{{ $post->postType->color }}">
                        <x-icon :name="$post->postType->icon" size="md"></x-icon>
                    </span>
                    <div class="font-bold text-xl tracking-tight truncate text-gray-900">{{ $post->title }}</div>
                </div>

                @if ($post->day || $post->time || $post->location)
                    <div class="flex space-x-4">
                        @if ($post->location)
                            <div class="flex items-center text-sm text-gray-600 space-x-1.5">
                                <x-icon name="location" size="sm" class="shrink-0 text-gray-500"></x-icon>
                                <span>{{ $post->location }}</span>
                            </div>
                        @endif

                        @if ($post->day)
                            <div class="flex items-center text-sm text-gray-600 space-x-1.5">
                                <x-icon name="calendar" size="sm" class="shrink-0 text-gray-500"></x-icon>
                                <span>{{ $post->day }}</span>
                            </div>
                        @endif

                        @if ($post->time)
                            <div class="flex items-center text-sm text-gray-600 space-x-1.5">
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
