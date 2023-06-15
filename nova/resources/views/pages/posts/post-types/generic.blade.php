<div class="relative">
    <div class="absolute right-0 top-0">
        <x-dropdown placement="bottom-end">
            <x-slot name="trigger">
                <x-icon.more class="h-6 w-6" />
            </x-slot>

            <x-dropdown.group>
                <x-dropdown.item :href="route('posts.show', [$story, $post])" icon="show" data-cy="view">
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

    <div class="space-y-2">
        <div class="flex items-center space-x-2">
            <div class="shrink-0" style="border-color: {{ $post->postType->color }}; color: {{ $post->postType->color }}">
                <x-icon :name="$post->postType->icon" size="sm"></x-icon>
            </div>

            <h3 class="text-xl font-bold tracking-tight text-gray-900">{{ $post->title }}</h3>
        </div>

        @if ($post->day || $post->time || $post->location)
            <div class="flex flex-col space-y-2 sm:flex-row sm:space-x-6 sm:space-y-0">
                @if ($post->location)
                    <div class="flex items-center space-x-1.5 text-sm font-medium text-gray-600">
                        <x-icon name="location" size="sm" class="shrink-0 text-gray-500"></x-icon>
                        <span>{{ $post->location }}</span>
                    </div>
                @endif

                @if ($post->day)
                    <div class="flex items-center space-x-1.5 text-sm font-medium text-gray-600">
                        <x-icon name="calendar" size="sm" class="shrink-0 text-gray-500"></x-icon>
                        <span>{{ $post->day }}</span>
                    </div>
                @endif

                @if ($post->time)
                    <div class="flex items-center space-x-1.5 text-sm font-medium text-gray-600">
                        <x-icon name="clock" size="sm" class="shrink-0 text-gray-500"></x-icon>
                        <span>{{ $post->time }}</span>
                    </div>
                @endif
            </div>
        @endif

        <div class="block">
            <div class="relative z-0 flex -space-x-2 overflow-hidden">
                <img class="relative z-30 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                <img class="relative z-20 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                <img class="relative z-10 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="" />
                <img class="relative z-0 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            </div>
        </div>

        {{-- <p class="leading-7 mt-1">{{ $post->description }}</p> --}}

        <div class="flex flex-col space-y-2 sm:flex-row sm:space-x-6 sm:space-y-0">
            <div>
                <x-badge :color="$post->status->color()">{{ $post->status->displayName() }}</x-badge>
            </div>

            @if ($post->published_at)
                <div class="flex items-center text-sm text-gray-600">
                    Published&nbsp;
                    <time datetime="{{ $post->published_at }}">
                        {{ $post->published_at->format('M d, Y') }}
                    </time>
                </div>
            @else
                <div class="flex items-center text-sm text-gray-600">
                    Last updated&nbsp;
                    <time datetime="{{ $post->updated_at }}">
                        {{ $post->updated_at->format('M d, Y') }}
                    </time>
                </div>
            @endif
        </div>
    </div>
</div>

{{--
    <x-panel>
    <x-content-box class="flex items-start relative">
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
    <x-dropdown.item-danger type="button" icon="trash" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($post) }});" data-cy="delete">
    <span>Delete</span>
    </x-dropdown.item-danger>
    </x-dropdown.group>
    @endcan
    </x-dropdown>
    </div>
    
    <div class="shrink-0 rounded-full p-1.5 border-2" style="border-color:{{ $post->postType->color }};color:{{ $post->postType->color }}">
    <x-icon :name="$post->postType->icon" size="md"></x-icon>
    </div>
    
    <div class="w-full space-y-4 sm:space-y-2 ml-4">
    <div>
    <h3 class="uppercase tracking-wide text-xs text-gray-500 font-semibold">{{ $post->postType->name }}</h3>
    <h2 class="flex-wrap font-bold text-lg tracking-tight text-gray-900 sm:text-2xl">{{ $post->title }}</h2>
    </div>
    
    @if ($post->day || $post->time || $post->location)
    <div class="flex flex-col space-y-2 sm:space-y-0 sm:space-x-6 sm:flex-row">
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
    
    <div class="block">
    <div class="flex -space-x-2 relative z-0 overflow-hidden">
    <img class="relative z-30 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
    <img class="relative z-20 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
    <img class="relative z-10 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
    <img class="relative z-0 inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
    </div>
    </div>
    
    <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-6">
    <div>
    <x-badge :color="$post->status->color()">{{ $post->status->displayName() }}</x-badge>
    </div>
    
    @if ($post->published_at)
    <div class="flex items-center text-sm text-gray-600">
    Published&nbsp;
    <time datetime="{{ $post->published_at }}">
    {{ $post->published_at->format('M d, Y') }}
    </time>
    </div>
    @else
    <div class="flex items-center text-sm text-gray-600">
    Last updated&nbsp;
    <time datetime="{{ $post->updated_at }}">
    {{ $post->updated_at->format('M d, Y') }}
    </time>
    </div>
    @endif
    </div>
    </div>
    </x-content-box>
    </x-panel>
--}}
