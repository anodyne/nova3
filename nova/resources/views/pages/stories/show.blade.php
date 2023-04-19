@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('details')">
        <x-panel.header :title="$story->title">
            <x-slot:actions>
                @can('update', $story)
                    <x-button-filled :href="route('stories.edit', $story)" color="primary">
                        Edit story
                    </x-button-filled>
                @endcan
            </x-slot:actions>

            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="details">Details</option>
                        @if ($story->post_count > 0)
                            <option value="posts">Posts</option>
                        @endif
                        <option value="summary">Summary</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
                        <nav class="-mb-px flex">
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('details'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('details') }" @click.prevent="switchTab('details')">
                                Details
                            </a>

                            @if ($story->post_count > 0)
                                <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('posts'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('posts') }" @click.prevent="switchTab('posts')">
                                    Posts
                                </a>
                            @endif

                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('summary'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('summary') }" @click.prevent="switchTab('summary')">
                                Summary
                            </a>
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>


        <x-content-box class="space-y-8" x-show="isTab('details')">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
                <div>
                    <x-badge :color="$story->status->color()">
                        {{ $story->status->displayName() }}
                    </x-badge>
                </div>

                @if ($story->start_date)
                    <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 md:text-sm font-medium">
                        @icon('calendar', 'h-6 w-6')
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
                    <div class="flex items-center">
                        <x-link :href="route('stories.show', $ancestors->last())" size="none" color="gray-primary-text">
                            <div class="flex items-center space-x-2">
                                @icon('book', 'h-6 w-6 shrink-0')
                                <span>Part of {{ $ancestors->last()->title }}</span>
                            </div>
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
                </div>
            </div>

            <div class="py-6 grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">Total posts</p>
                    <p class="mt-2 flex items-baseline gap-x-2">
                        <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            {{ number_format((int) $story->posts_count) }}
                        </span>
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">Total words</p>
                    <p class="mt-2 flex items-baseline gap-x-2">
                        <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            {{ number_format((int) $story->words_count) }}
                        </span>
                    </p>
                </div>

                @if ($story->children->count() > 0)
                    <div>
                        <p class="text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">Total posts in all stories</p>
                        <p class="mt-2 flex items-baseline gap-x-2">
                            <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ number_format((int) $story->recursive_posts_count) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">Total words in all stories</p>
                        <p class="mt-2 flex items-baseline gap-x-2">
                            <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ number_format((int) $story->recursive_posts_sum_word_count) }}
                            </span>
                        </p>
                    </div>
                @endif
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
                                    <x-link :href="route('stories.show', $subStory)" color="primary-outline" size="sm" full-width>
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
