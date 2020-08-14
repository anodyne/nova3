@props([
    'stories'
])

<div class="border-r-2 border-gray-300 absolute z-0 h-full top-0" style="left: 15px"></div>
<ul class="relative z-10 list-none m-0 p-0 space-y-8">
    @foreach ($stories as $story)
        <li>
            <div class="flex">
                <div class="flex-shrink-0 border-8 border-gray-100 bg-gray-300 rounded-full h-8 w-8 mt-4 | sm:mt-6"></div>


                <div class="ml-6 w-full">
                    <x-panel class="p-4 | sm:p-6">
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-bold tracking-tight">{{ $story->title }}</div>
                            <div class="leading-0">
                                <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500" :wide="true">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('show', $component->icon())
                                        <span>View</span>
                                    </a>

                                    <a href="#" class="{{ $component->link() }}">
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

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('chevron-left', $component->icon())
                                        <span>Before {{ $story->title }}</span>
                                    </a>

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('chevron-right', $component->icon())
                                        <span>After {{ $story->title }}</span>
                                    </a>

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('chevron-down', $component->icon())
                                        <span>Inside {{ $story->title }}</span>
                                    </a>

                                    <div class="{{ $component->divider() }}"></div>

                                    <a href="#" class="{{ $component->link() }}">
                                        @icon('delete', $component->icon())
                                        <span>Delete</span>
                                    </a>
                                </x-dropdown>
                            </div>
                        </div>
                        <p class="leading-7 text-gray-600 mt-1">{{ $story->description }}</p>
                        <div class="flex items-center space-x-8 mt-1 text-sm text-gray-500">
                            <span>
                                <x-badge :type="$story->status->color()" size="sm">{{ $story->status->displayName() }}</x-badge>
                            </span>

                            <span>{{ mt_rand(2, 500) }} posts</span>

                            @if ($story->stories_count > 0)
                                <span>{{ mt_rand(500, 800) }} posts in all stories</span>
                            @endif
                        </div>
                    </x-panel>
                </div>
            </div>

            @if ($story->stories_count > 0)
                <div class="relative w-full ml-16 pt-8">
                    <x-stories.timeline-original :stories="$story->stories" />
                </div>
            @endif
        </li>
    @endforeach
</ul>
