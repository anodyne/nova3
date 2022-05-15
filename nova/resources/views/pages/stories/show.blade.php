@extends($meta->template)

@section('content')
    <x-page-header :title="$story->title">
        <x-slot:pretitle>
            <div class="flex items-center">
                <a href="{{ route('stories.index') }}">Stories</a>

                @if ($ancestors->count() > 0)
                    @foreach ($ancestors as $ancestor)
                        <x-icon.chevron-right class="h-4 w-4 text-gray-500 mx-1" />
                        <a href="{{ route('stories.show', $ancestor) }}">
                            {{ $ancestor->title }}
                        </a>
                    @endforeach
                @endif
            </div>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $story)
                <x-link :href="route('stories.edit', $story)" color="blue">
                    Edit Story
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel x-data="tabsList('details')">
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="form-select bg-white dark:bg-gray-700/50 block w-full pl-3 pr-10 py-2 text-base border-gray-200 dark:border-gray-200/10 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 dark:focus:border-blue-400 transition rounded-md">
                    <option value="details">Details</option>

                    @if ($story->post_count > 0)
                        <option value="posts">Posts</option>
                    @endif

                    <option value="summary">Summary</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <x-content-box height="none" class="border-b border-gray-200 dark:border-gray-200/10">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none transition" :class="{ 'border-blue-400 text-blue-500': isTab('details'), 'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500': isNotTab('details') }" @click.prevent="switchTab('details')">
                            Details
                        </a>

                        @if ($story->post_count > 0)
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none transition" :class="{ 'border-blue-400 text-blue-500': isTab('posts'), 'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500': isNotTab('posts') }" @click.prevent="switchTab('posts')">
                                Posts
                            </a>
                        @endif

                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none transition" :class="{ 'border-blue-400 text-blue-500': isTab('summary'), 'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500': isNotTab('summary') }" @click.prevent="switchTab('summary')">
                            Summary
                        </a>
                    </nav>
                </x-content-box>
            </div>
        </div>

        <x-content-box class="space-y-8" x-show="isTab('details')">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
                <div>
                    <x-badge :color="$story->status->color()" size="xs">
                        {{ $story->status->displayName() }}
                    </x-badge>
                </div>

                @if ($story->start_date)
                    <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 md:text-sm">
                        @icon('calendar', 'h-6 w-6 text-gray-400 dark:text-gray-500')
                        <span>
                            @if (! $story->end_date)
                                Started on
                            @endif
                            {{ $story->start_date->format('M dS, Y') }}
                            @if ($story->end_date)
                                &ndash; {{ $story->end_date->format('M dS, Y') }}
                            @endif
                        </span>
                    </div>
                @endif

                @if ($ancestors->count() > 0)
                    <div>
                        <x-link :href="route('stories.show', $ancestors->last())" size="none" color="gray-blue-text">
                            @icon('book', 'h-6 w-6 shrink-0')
                            <span class="ml-2">Part of {{ $ancestors->last()->title }}</span>
                        </x-link>
                    </div>
                @endif
            </div>

            <div class="grid md:grid-cols-8 gap-8">
                <div class="md:col-span-5">
                    <img class="h-60 w-full object-cover rounded-lg" src="{{ asset("dist/test5.jpg") }}" alt="" />
                </div>
                <div class="md:col-span-3">
                    <p class="text-lg text-gray-500 dark:text-gray-400">{{ $story->description }}</p>

                    <div class="flex flex-col sm:flex-row mt-6 space-y-4 sm:space-y-0 sm:space-x-8">
                        @if ($story->post_count > 0)
                            <div>
                                <dt class="text-base md:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    <span class="inline md:hidden xl:inline">Total</span>
                                    Posts
                                </dt>
                                <dd class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">
                                    {{ number_format($story->post_count) }}
                                </dd>
                            </div>
                        @endif

                        @if ($story->getDescendantCount() > 0)
                            <div>
                                <dt class="text-base md:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    <span class="inline md:hidden xl:inline">Total</span>
                                    Posts in All Stories
                                </dt>
                                <dd class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">
                                    {{ number_format($story->all_stories_post_count) }}
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($story->children->count() > 0)
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">Stories Within {{ $story->title }}</h2>

                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4">
                        @foreach ($story->children as $subStory)
                            <x-panel as="light well" class="flex flex-col justify-between">
                                <div>
                                    <img class="h-48 w-full object-cover sm:rounded-t-lg" src="{{ asset("dist/test".$loop->iteration.".jpg") }}" alt="" />

                                    <x-content-box height="xs" width="sm">
                                        <h3 class="text-gray-600 dark:text-gray-400 font-extrabold text-lg tracking-tight">{{ $subStory->title }}</h3>

                                        <p class="text-gray-600 dark:text-gray-400 text-base md:text-sm mt-2">{{ $subStory->description }}</p>
                                    </x-content-box>
                                </div>

                                <x-content-box height="sm" width="sm">
                                    <x-link :href="route('stories.show', $subStory)" color="blue-outline" size="sm" full-width>
                                        View story
                                    </x-link>
                                </x-content-box>
                            </x-panel>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-content-box>

        <div x-show="isTab('posts')" x-cloak>
            @livewire('stories:posts-list', ['story' => $story])
        </div>

        <x-content-box x-show="isTab('summary')" x-cloak>
            <div class="prose prose-lg max-w-none">
                {!! $story->summary !!}
            </div>
        </x-content-box>
    </x-panel>
@endsection
