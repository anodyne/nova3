@props([
    'stories'
])

<div class="border-r-2 border-gray-300 absolute z-0 h-full top-0" style="left:25px;"></div>
<ul class="relative z-10 list-none m-0 p-0 space-y-8">
    @foreach ($stories as $story)
        <li class="relative">
            <div class="flex">
                <div class="absolute flex-shrink-0 bg-gray-300 rounded-full h-6 w-6 -mt-2" style="left:14px"></div>

                <div class="w-full">
                    <x-panel class="p-4 | sm:p-6">
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-bold tracking-tight">{{ $story->title }}</div>
                            <div class="leading-0">
                                <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500" :wide="true">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                    <a href="{{ route('stories.show', $story) }}" class="{{ $component->link() }}">
                                        @icon('show', $component->icon())
                                        <span>View</span>
                                    </a>

                                    <a href="{{ route('stories.edit', $story) }}" class="{{ $component->link() }}">
                                        @icon('edit', $component->icon())
                                        <span>Edit</span>
                                    </a>

                                    <div class="{{ $component->divider() }}"></div>

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('list', $component->icon())
                                        <span>Posts</span>
                                    </a>

                                    <div class="{{ $component->divider() }}"></div>

                                    <div class="uppercase tracking-wide font-semibold text-gray-400 {{ $component->text() }}">
                                        Add a story
                                    </div>

                                    <a href="{{ route('stories.create', "direction=before&neighbor={$story->id}") }}" class="{{ $component->link() }}">
                                        @icon('move-up', $component->icon())
                                        <span>Before {{ $story->title }}</span>
                                    </a>

                                    <a href="{{ route('stories.create', "direction=after&neighbor={$story->id}") }}" class="{{ $component->link() }}">
                                        @icon('move-down', $component->icon())
                                        <span>After {{ $story->title }}</span>
                                    </a>

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('move-right', $component->icon())
                                        <span>Inside {{ $story->title }}</span>
                                    </a>

                                    @can('delete', $story)
                                        <div class="{{ $component->divider() }}"></div>
                                        <a href="{{ route('stories.delete', $story) }}" class="{{ $component->link() }}">
                                            @icon('delete', $component->icon())
                                            <span>Delete</span>
                                        </a>
                                    @endcan
                                </x-dropdown>
                            </div>
                        </div>
                        <p class="text-gray-600 mt-1">{{ $story->description }}</p>
                        <div class="flex items-center space-x-8 mt-2 text-sm text-gray-500">
                            <span>
                                <x-badge :type="$story->status->color()" size="sm">{{ $story->status->displayName() }}</x-badge>
                            </span>

                            <span>{{ mt_rand(2, 500) }} posts</span>

                            @if ($story->getDescendantCount() > 0)
                                <span>{{ mt_rand(500, 800) }} posts in all stories</span>
                            @endif
                        </div>
                    </x-panel>
                </div>
            </div>

            @if ($story->getDescendantCount() > 0)
                <div class="relative w-full ml-16 pt-8">
                    <x-stories.timeline :stories="$story->children" />
                </div>
            @endif
        </li>
    @endforeach
</ul>
