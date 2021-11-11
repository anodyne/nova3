<div>
    <x-content-box>
        <h3 class="font-bold text-xl text-gray-12 tracking-tight">Story Posts</h3>

        <div class="flex justify-between mt-4">
            @if ($posts->total() > 0)
                <div class="w-full sm:w-1/3">
                    <x-input.group>
                        <x-input.text wire:model.debounce.500ms="filters.search" placeholder="Find story post...">
                            <x-slot name="leadingAddOn">
                                @icon('search', 'h-5 w-5')
                            </x-slot>

                            <x-slot name="trailingAddOn">
                                @if ($filters['search'])
                                    <x-button color="gray-text" size="none" wire:click="$set('filters.search', '')">
                                        @icon('close')
                                    </x-button>
                                @endif
                            </x-slot>
                        </x-input.text>
                    </x-input.group>
                </div>

                @can('update', $story)
                    <div class="flex items-center space-x-4">
                        @if (count($selected) > 0)
                            <x-button color="red-outline" size="sm" wire:click="detachSelectedPermissions">
                                Remove {{ count($selected) }} @choice('permission|permissions', count($selected))
                            </x-button>
                        @endif

                        <x-link :href="route('posts.create')" color="blue" size="sm">
                            Write a Story Post
                        </x-link>
                    </div>
                @endcan
            @endif
        </div>
    </x-content-box>

    @if ($posts->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot name="head">
                @can('update', $story)
                    <x-table.heading class="pr-0 w-8 leading-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endcan

                <x-table.heading class="pr-0 w-8 leading-0" />
                <x-table.heading>Title</x-table.heading>
                <x-table.heading>Location</x-table.heading>
                <x-table.heading>Day/Time</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-blue-3" colspan="3">
                            @unless ($selectAll)
                                <div>
                                    <span class="text-blue-11">You've selected <strong>{{ $posts->count() }}</strong> permissions assigned to this role. Do you want to select all <strong>{{ $posts->total() }}</strong>?</span>

                                    <x-button size="none" color="blue-text" wire:click="selectAll" class="ml-1">Select All</x-button>
                                </div>
                            @else
                                <span class="text-blue-11">You've selected all <strong>{{ $posts->total() }}</strong> permissions assigned to this role.</span>
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
                            <span style="color:{{ $post->type->color }}">
                                @icon($post->type->icon, 'h-5 w-5 flex-shrink-0')
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
            <x-content-box class="border-t border-gray-3" height="xs">
                {{ $posts->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            @icon('lock', 'mx-auto h-12 w-12 text-gray-9')

            <h3 class="mt-2 text-sm font-medium text-gray-12">No posts</h3>

            @can('update', $story)
                <p class="mt-1 text-sm text-gray-11">
                    Get started by assigning permissions to this role.
                </p>

                <div class="mt-6">
                    <x-button color="blue" wire:click="$emit('openModal', 'roles:select-permissions-modal')">
                        Add permissions
                    </x-button>
                </div>
            @endcan
        </x-content-box>
    @endif
</div>
