@extends($meta->template)

@section('content')
@php
    $filesVersion = '3.0.1';
    $databaseVersion = '3.0.1';
    $serverVersion = '3.0.2';
@endphp

<div>
    <x-panel>
        <x-panel.header
            title="My draft posts"
            message="Drafts are posts in progress that have not been published"
            :bottom-border="$posts->count() === 0"
        >
            @if ($posts->count() > 0)
                <x-slot:actions>
                    <x-button.filled :href="route('posts.create')" leading="write" color="primary">
                        Start writing
                    </x-button.filled>
                </x-slot:actions>
            @endif
        </x-panel.header>

        @if ($posts->count() > 0)
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

                            <x-slot:actions>
                                <x-button.text :href="route('posts.create', $post)" color="gray">
                                    <x-icon name="edit" size="md"></x-icon>
                                </x-button.text>
                            </x-slot:actions>
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
