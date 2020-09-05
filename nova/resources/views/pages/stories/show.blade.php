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

        <x-panel x-data="AlpineComponents.tabsList()" class="mt-8">
            <div>
                <div class="p-4 | sm:hidden">
                    <select x-on:change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm transition ease-in-out duration-150">
                        <option value="{{ route('characters.index', 'status=active') }}"{{ request()->status === 'active' ? 'selected' : '' }}>Story Posts</option>
                        <option value="{{ route('characters.index', 'status=pending') }}"{{ request()->status === 'pending' ? 'selected' : '' }}>Story Summary</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div class="border-b border-gray-200 px-4 | sm:px-6">
                        <nav class="-mb-px flex">
                            <a
                            x-on:click.prevent="switchTab('posts')"
                            href="#"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'posts', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'posts' }"
                            >
                            Posts
                        </a>
                        <a
                        x-on:click.prevent="switchTab('summary')"
                        href="#"
                        class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none"
                        x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'summary', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'summary' }"
                        >
                        Summary
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div>
        <div x-show="tab === 'posts'" x-cloak>
            <ul>
                @for ($i = 0; $i <= 15; $i++)
                <li class="border-t border-gray-200 first:border-0">
                    <a href="#" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <div class="font-medium text-blue-600 truncate">Post title</div>
                                        <div class="mt-1 flex items-center text-sm text-gray-500">
                                            Published on January 7, 2020
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden | md:block md:mx-6">
                                    <div class="flex overflow-hidden">
                                        <img class="inline-block h-6 w-6 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        <img class="-ml-1 inline-block h-6 w-6 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        <img class="-ml-1 inline-block h-6 w-6 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                                        <img class="-ml-1 inline-block h-6 w-6 rounded-full text-white shadow-solid" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
                @endfor
            </ul>
        </div>

        <div x-show="tab === 'summary'" x-cloak>
            @if ($story->summary)
            {!! $story->summary !!}
            @else
            No summary yet, come back later.
            @endif
        </div>
    </div>
</x-panel>
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

{{-- @if ($story->children->count() > 0)


    <div class="grid gap-6 max-w-lg mx-auto | lg:grid-cols-3 lg:max-w-none">
        @foreach ($story->children as $subStory)
        <x-card x-data="{ id: {{ $subStory->id ?? 0 }} }">
            <x-slot name="header">
                <div class="flex-shrink-0">
                    <img class="h-48 w-full object-cover rounded-t-md" src="https://images.unsplash.com/photo-1595352167836-837595f989b2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80" alt="" />
                </div>
            </x-slot>

            <div class="flex items-center justify-between">
                <h3 class="inline-flex items-center text-xl font-semibold text-gray-900">
                    {{ $subStory->title }}
                </h3>
            </div>
            <x-badge class="mt-1" size="sm" :type="$subStory->status->color()">{{ $subStory->status->displayName() }}</x-badge>
            <p class="mt-1 flex items-center text-sm text-gray-500">
                {{ $subStory->description }}
            </p>
        </x-card>
        @endforeach
    </div>
    @endif --}}
    @endsection
