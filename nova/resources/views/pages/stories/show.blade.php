@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$story->title">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <div class="grid gap-8 | lg:grid-cols-4">
        <div class="order-2 | lg:col-span-3 lg:order-1">
            <p class="text-lg">{{ $story->description }}</p>

            <div class="flex items-center justify-between w-full my-8">
                <x-input.group class="w-full | sm:w-1/2">
                    <x-input.text id="name" name="name" data-cy="name" placeholder="Find a story post...">
                        <x-slot name="leadingAddOn">
                            @icon('search')
                        </x-slot>
                    </x-input.text>
                </x-input.group>

                <div class="flex items-center">
                    <x-dropdown placement="bottom-end" wide class="mr-4">
                        <x-slot name="trigger">@icon('filter', 'h-6 w-6')</x-slot>

                        <div class="{{ $component->text() }}">
                            <x-input.checkbox for="story_posts" id="story_posts" label="Show story posts" checked />
                        </div>
                        <div class="{{ $component->text() }}">
                            <x-input.checkbox label="Show journel entries" checked />
                        </div>
                        <div class="{{ $component->text() }}">
                            <x-input.checkbox label="Show markers" checked />
                        </div>
                        <div class="{{ $component->text() }}">
                            <x-input.checkbox label="Show story notes" checked />
                        </div>
                        <div class="{{ $component->text() }} space-x-2">
                            <x-button color="blue" size="xs">Apply</x-button>
                            <x-button color="white" size="xs">Reset</x-button>
                        </div>
                    </x-dropdown>

                    <x-dropdown placement="bottom-end" wide>
                        <x-slot name="trigger">@icon('arrow-sort', 'h-6 w-6')</x-slot>

                        <a href="{{ route('stories.show', [$story, 'sort=asc']) }}" class="{{ $component->link() }} justify-between">
                            <span>Sort by newest chronologically</span>
                            @if (request('sort') === 'asc')
                                @icon('check', 'h-5 w-5')
                            @endif
                        </a>
                        <a href="{{ route('stories.show', [$story, 'sort=desc']) }}" class="{{ $component->link() }} justify-between">
                            <span>Sort by oldest chronologically</span>
                            @if (request('sort') === 'desc')
                                @icon('check', 'h-5 w-5')
                            @endif
                        </a>
                        <a href="{{ route('stories.show', [$story, 'sort=published']) }}" class="{{ $component->link() }} justify-between">
                            <span>Sort by published</span>
                            @if (request('sort') === 'published')
                                @icon('check', 'h-5 w-5')
                            @endif
                        </a>
                    </x-dropdown>
                </div>
            </div>

            <div class="relative">
                {{-- <div class="flex items-center justify-between px-4 py-2 | sm:px-6 sm:py-3">
                    <x-search-filter placeholder="Find a post..." :search="$search" />

                    <div class="flex-shrink-0 leading-0">
                        <x-dropdown placement="bottom-end" wide>
                            <x-slot name="trigger">@icon('filter', 'h-6 w-6')</x-slot>

                            <a href="{{ route('stories.show', [$story, 'sort=asc']) }}" class="{{ $component->link() }} justify-between">
                                <span>Sort by newest chronologically</span>
                                @if (request('sort') === 'asc')
                                    @icon('check', 'h-5 w-5')
                                @endif
                            </a>
                            <a href="{{ route('stories.show', [$story, 'sort=desc']) }}" class="{{ $component->link() }} justify-between">
                                <span>Sort by oldest chronologically</span>
                                @if (request('sort') === 'desc')
                                    @icon('check', 'h-5 w-5')
                                @endif
                            </a>
                            <a href="{{ route('stories.show', [$story, 'sort=published']) }}" class="{{ $component->link() }} justify-between">
                                <span>Sort by published</span>
                                @if (request('sort') === 'published')
                                    @icon('check', 'h-5 w-5')
                                @endif
                            </a>
                        </x-dropdown>
                    </div>
                </div> --}}

                <div class="border-r-4 border-gray-200 absolute z-0 h-full top-0 rounded-full" style="left:50%"></div>

                <ul class="relative z-10 list-none m-0 p-0 space-y-8">
                    @forelse ($posts as $post)
                        <li>
                            @if (view()->exists("pages.posts.post-types.{$post->type->key}"))
                                @include("pages.posts.post-types.{$post->type->key}")
                            @else
                                @include('pages.posts.post-types.generic')
                            @endif
                        </li>
                    @empty
                        <x-search-not-found>
                            No story posts found
                        </x-search-not-found>
                    @endforelse
                </ul>

                {{-- <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                    {{ $posts->withQueryString()->links() }}
                </div> --}}
            </div>
        </div>

        <div class="order-1 | lg:col-span-1 lg:order-2">
            @can('update', $story)
            <div class="mb-8">
                <x-button-link :href="route('stories.edit', $story)" color="blue" full-width data-cy="create">
                    Edit Story
                </x-button-link>
            </div>
            @endcan

            <div class="space-y-4">
                <div>
                    <x-badge :color="$story->status->color()">{{ $story->status->displayName() }}</x-badge>
                </div>

                @if ($story->start_date)
                <div class="flex items-center space-x-2 text-gray-600 text-sm">
                    @icon('clock', 'text-gray-500')
                    <span>Started {{ $story->start_date->format('M dS, Y') }}</span>
                </div>
                @endif

                @if ($story->end_date)
                <div class="flex items-center space-x-2 text-gray-600 text-sm">
                    @icon('clock', 'text-gray-500')
                    <span>Ended {{ $story->end_date->format('M dS, Y') }}</span>
                </div>
                @endif
            </div>

            @if ($story->children->count() > 0)
            <div class="mt-8">
                <h2 class="mb-4 text-lg font-semibold text-gray-700">Stories Within {{ $story->title }}</h2>

                <ul class="list-none space-y-1">
                    @foreach ($story->children as $subStory)
                    <li>
                        <a href="{{ route('stories.show', $subStory) }}" class="block px-2 py-1 rounded-md transition ease-in-out duration-150 hover:bg-gray-200">{{ $subStory->title }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
@endsection
