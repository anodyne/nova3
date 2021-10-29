<div class="block bg-gray-3">
    <div class="flex items-center relative px-4 py-4 sm:px-6">
        <div class="absolute top-0 right-0 pt-4 pr-4 sm:pr-6">
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
                    <x-dropdown.text class="uppercase tracking-wide font-semibold text-gray-9">
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
                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($post) }});" data-cy="delete">
                            <span>Delete</span>
                        </x-dropdown.item-danger>
                    </x-dropdown.group>
                @endcan
            </x-dropdown>
        </div>

        <div class="flex flex-col items-center flex-1">
            <div class="flex flex-col flex-1 w-full space-y-2">
                <div class="flex items-center space-x-2 justify-center">
                    <span style="color:{{ $post->type->color }}">
                        @icon($post->type->icon, 'h-6 w-6')
                    </span>
                    <div class="font-bold text-xl tracking-tight truncate text-gray-12">{{ $post->title ?? 'Story Note' }}</div>
                </div>

                @if ($post->day || $post->time || $post->location)
                    <div class="flex justify-center space-x-4">
                        @if ($post->location)
                            <div class="flex items-center text-sm text-gray-11 space-x-1.5">
                                @icon('location', 'flex-shrink-0 h-5 w-5 text-gray-9')
                                <span>{{ $post->location }}</span>
                            </div>
                        @endif

                        @if ($post->day)
                            <div class="flex items-center text-sm text-gray-11 space-x-1.5">
                                @icon('calendar', 'flex-shrink-0 h-5 w-5 text-gray-9')
                                <span>{{ $post->day }}</span>
                            </div>
                        @endif

                        @if ($post->time)
                            <div class="flex items-center text-sm text-gray-11 space-x-1.5">
                                @icon('clock', 'flex-shrink-0 h-5 w-5 text-gray-9')
                                <span>{{ $post->time }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="prose prose-sm max-w-full text-gray-12">{!! $post->content !!}</div>
            </div>
        </div>
    </div>
</div>