@props([
    'stories'
])

<div class="border-r-2 border-gray-6 absolute z-0 h-full top-0" style="left:25px;"></div>
<ul class="relative z-10 list-none m-0 p-0 space-y-8">
    @foreach ($stories as $story)
        <li class="relative">
            <div class="flex">
                <div class="absolute shrink-0 bg-gray-6 rounded-full h-6 w-6 -mt-2" style="left:14px"></div>

                <div class="w-full">
                    <x-panel>
                        <x-content-box>
                            <div class="flex items-center justify-between">
                                <div class="text-xl font-bold tracking-tight">{{ $story->title }}</div>
                                <div class="leading-0">
                                    <x-dropdown placement="bottom-end" wide>
                                        <x-slot name="trigger">
                                            <x-icon.more class="h-6 w-6" />
                                        </x-slot>

                                        <x-dropdown.group>
                                            @can('view', $story)
                                                <x-dropdown.item :href="route('stories.show', $story)" icon="show">
                                                    <span>View</span>
                                                </x-dropdown.item>
                                            @endcan

                                            @can('update', $story)
                                                <x-dropdown.item :href="route('stories.edit', $story)" icon="edit">
                                                    <span>Edit</span>
                                                </x-dropdown.item>
                                            @endcan
                                        </x-dropdown.group>

                                        <x-dropdown.group>
                                            <x-dropdown.item icon="list">
                                                <span>Posts</span>
                                            </x-dropdown.item>
                                        </x-dropdown.group>

                                        @can('create', $story)
                                            <x-dropdown.group>
                                                <x-dropdown.text class="uppercase tracking-wide font-semibold text-gray-9">
                                                    Add a story
                                                </x-dropdown.text>
                                                <x-dropdown.item :href='route("stories.create", "direction=before&neighbor={$story->id}")' icon="move-up">
                                                    <span>Before {{ $story->title }}</span>
                                                </x-dropdown.item>
                                                <x-dropdown.item :href='route("stories.create", "direction=after&neighbor={$story->id}")' icon="move-down">
                                                    <span>After {{ $story->title }}</span>
                                                </x-dropdown.item>
                                                <x-dropdown.item :href='route("stories.create", "parent={$story->id}")' icon="move-right">
                                                    <span>Inside {{ $story->title }}</span>
                                                </x-dropdown.item>
                                            </x-dropdown.group>
                                        @endcan

                                        @can('delete', $story)
                                            <x-dropdown.group>
                                                <x-dropdown.item-danger :href="route('stories.delete', $story)" icon="delete">
                                                    <span>Delete</span>
                                                </x-dropdown.item-danger>
                                            </x-dropdown.group>
                                        @endcan
                                    </x-dropdown>
                                </div>
                            </div>

                            <p class="text-gray-11 mt-2">{{ $story->description }}</p>

                            <div class="flex items-center space-x-8 mt-3 text-sm text-gray-9">
                                <span>
                                    @livewire('stories:status', ['story' => $story])
                                </span>

                                <span>{{ $story->posts()->count() }} @choice('post|posts', $story->posts()->count())</span>

                                @if ($story->getDescendantCount() > 0)
                                    <span>{{ mt_rand(500, 800) }} posts in all stories</span>
                                @endif
                            </div>
                        </x-content-box>
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
