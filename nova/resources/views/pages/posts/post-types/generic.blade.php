<div class="block bg-gray-1 rounded-md shadow">
    <div class="flex items-start relative space-x-4 px-4 py-4 sm:px-6">
        <div class="absolute top-0 right-0 pt-4 pr-4 sm:pr-6">
            <x-dropdown placement="bottom-end">
                <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

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
                        <x-dropdown.item type="button" icon="delete" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($post) }});" data-cy="delete">
                            <span>Delete</span>
                        </x-dropdown.item>
                    </x-dropdown.group>
                @endcan
            </x-dropdown>
        </div>

        <div class="flex-shrink-0 rounded-full p-1.5 border-2" style="border-color:{{ $post->type->color }};color:{{ $post->type->color }}">
            @icon($post->type->icon, 'h-5 w-5 sm:h-6 sm:w-6')
        </div>

        <div class="w-full space-y-4 sm:space-y-2">
            <div>
                <h3 class="uppercase tracking-wide text-xs text-gray-9 font-semibold">{{ $post->type->name }}</h3>
                <h2 class="flex-wrap font-bold text-lg tracking-tight text-gray-12 sm:text-2xl">{{ $post->title }}</h2>
            </div>

            @if ($post->day || $post->time || $post->location)
                <div class="flex flex-col space-y-2 sm:space-y-0 sm:space-x-6 sm:flex-row">
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

                    @if ($post->location)
                        <div class="flex items-center text-sm text-gray-11 space-x-1.5">
                            @icon('location', 'flex-shrink-0 h-5 w-5 text-gray-9')
                            <span>{{ $post->location }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="block">
                <div class="flex overflow-hidden">
                    <img class="inline-block h-8 w-8 rounded-full text-gray-1 shadow-solid" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="-ml-1 inline-block h-8 w-8 rounded-full text-gray-1 shadow-solid" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="-ml-1 inline-block h-8 w-8 rounded-full text-gray-1 shadow-solid" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                    <img class="-ml-1 inline-block h-8 w-8 rounded-full text-gray-1 shadow-solid" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </div>
            </div>

            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-6">
                <div>
                    <x-badge :color="$post->status->color()" size="xs">{{ $post->status->displayName() }}</x-badge>
                </div>

                @if ($post->published_at)
                    <div class="flex items-center text-sm text-gray-11">
                        Published&nbsp;
                        <time datetime="{{ $post->published_at }}">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>
                @else
                    <div class="flex items-center text-sm text-gray-11">
                        Last updated&nbsp;
                        <time datetime="{{ $post->updated_at }}">
                            {{ $post->updated_at->format('M d, Y') }}
                        </time>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>