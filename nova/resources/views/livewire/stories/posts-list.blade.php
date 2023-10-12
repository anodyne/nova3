<div>
    <x-content-box>
        <div class="flex justify-between">
            <div>
                <div class="flex items-center space-x-4">
                    <x-h2>Story Posts</x-h2>
                    <x-badge color="primary" size="xs">{{ $story->post_count }}</x-badge>
                </div>
                <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet.</p>
            </div>

            @can('update', $story)
                <div class="flex items-center space-x-4">
                    @if (count($selected) > 0)
                        <x-button.outline color="danger" wire:click="detachSelectedPermissions">
                            Remove {{ count($selected) }}
                            @choice('permission|permissions', count($selected))
                        </x-button.outline>
                    @endif

                    <x-button.outline :href="route('posts.create')" color="primary">
                        Write a Story Post
                    </x-button.outline>
                </div>
            @endcan
        </div>

        <div class="mt-4 flex justify-between">
            @if ($posts->total() > 0)
                <div class="w-full sm:w-1/3">
                    <x-input.group>
                        <x-input.text wire:model.live.debounce.500ms="filters.search" placeholder="Find story post...">
                            <x-slot name="leading">
                                <x-icon name="search" size="sm"></x-icon>
                            </x-slot>

                            <x-slot name="trailing">
                                @if ($filters['search'])
                                    <x-button.text color="subtle-neutral" wire:click="$set('filters.search', '')">
                                        <x-icon name="dismiss" size="sm"></x-icon>
                                    </x-button.text>
                                @endif
                            </x-slot>
                        </x-input.text>
                    </x-input.group>
                </div>
            @endif
        </div>
    </x-content-box>

    @if ($posts->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot:head>
                @can('update', $story)
                    <x-table.heading class="w-8 pr-0 leading-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endcan

                <x-table.heading class="w-8 pr-0 leading-0" />
                <x-table.heading>Title</x-table.heading>
                <x-table.heading>Location</x-table.heading>
                <x-table.heading>Day/Time</x-table.heading>
            </x-slot>

            <x-slot:body>
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-primary-50" colspan="3">
                            @unless ($selectAll)
                                <div>
                                    <span class="text-primary-600">
                                        You've selected
                                        <strong>{{ $posts->count() }}</strong>
                                        permissions assigned to this role. Do you want to select all
                                        <strong>{{ $posts->total() }}</strong>
                                        ?
                                    </span>

                                    <x-button.text color="primary" wire:click="selectAll" class="ml-1">
                                        Select All
                                    </x-button.text>
                                </div>
                            @else
                                <span class="text-primary-600">
                                    You've selected all
                                    <strong>{{ $posts->total() }}</strong>
                                    permissions assigned to this role.
                                </span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($posts as $post)
                    <x-table.row wire:key="row-{{ $post->id }}">
                        @can('update', $story)
                            <x-table.cell class="pr-0 leading-0">
                                <x-input.checkbox wire:model="selected" value="{{ $post->id }}" />
                            </x-table.cell>
                        @endcan

                        <x-table.cell class="pr-0 leading-0">
                            <span style="color: {{ $post->postType->color }}">
                                <x-icon :name="$post->postType->icon" size="sm" class="shrink-0"></x-icon>
                            </span>
                        </x-table.cell>
                        <x-table.cell>{{ $post->title }}</x-table.cell>
                        <x-table.cell>{{ $post->location }}</x-table.cell>
                        <x-table.cell>
                            {{ $post->day }}
                            @if ($post->day && $post->time)
                                &bull;
                            @endif

                            {{ $post->time }}
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>

        @if ($posts->total() > $posts->perPage())
            <x-content-box class="border-t border-gray-50" height="xs">
                {{ $posts->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            <x-icon name="lock-closed" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>

            <h3 class="mt-2 text-sm font-medium text-gray-900">No posts</h3>

            @can('update', $story)
                <p class="mt-1 text-sm text-gray-600">Get started by assigning permissions to this role.</p>

                <div class="mt-6">
                    <x-button.filled
                        color="primary"
                        wire:click="$dispatch('openModal', 'roles:select-permissions-modal')"
                    >
                        Add permissions
                    </x-button.filled>
                </div>
            @endcan
        </x-content-box>
    @endif
</div>
