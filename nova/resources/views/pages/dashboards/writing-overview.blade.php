@extends($meta->template)

@section('content')
@php
    $filesVersion = '3.0.1';
    $databaseVersion = '3.0.1';
    $serverVersion = '3.0.2';
@endphp

<div>
    <x-page-header>Writing Overview</x-page-header>

    <x-panel>
        @if ($posts->count() > 0)
            <x-content-box height="sm">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-medium text-lg text-gray-900 dark:text-gray-100 tracking-tight">My draft posts</h2>
                        <p class="mt-0.5 text-gray-500 text-sm">Drafts are posts currently in progress and that have not been published.</p>
                    </div>

                    <div>
                        <x-link :href="route('posts.create')" color="primary">
                            Start Writing
                        </x-link>
                    </div>
                </div>
            </x-content-box>

            <x-content-box width="none" height="none">
                <x-table-list columns="3">
                    <x-slot:header>
                        <div>Title</div>
                        <div>Location</div>
                        <div>Day/Time</div>
                    </x-slot:header>

                    @foreach ($posts as $post)
                        <x-table-list.row>
                            <div class="flex items-center w-full font-semibold">{{ $post->title }}</div>
                            <div class="flex items-center w-full">{{ $post->location }}</div>
                            <div class="flex items-center w-full">{{ $post->day }} {{ $post->time }}</div>

                            <x-slot:controls>
                                <x-link :href="route('posts.create', $post)" color="gray-text" size="none">
                                    @icon('edit', 'h-6 w-6')
                                </x-link>
                            </x-slot:controls>
                        </x-table-list.row>
                    @endforeach
                </x-table-list>
            </x-content-box>
        @else
            <x-empty-state.large
                icon="write"
                message="No draft posts found"
                :link-access="true"
                :link="route('posts.create')"
                label="Start writing"
            ></x-empty-state.large>
        @endif
    </x-panel>
</div>
@endsection
