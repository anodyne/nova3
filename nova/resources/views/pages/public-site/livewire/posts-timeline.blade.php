<x-spacing>
    @if ($posts->count() > 0)
        <x-feed class="mt-12">
            @foreach ($posts as $post)
                @php
                    $showMetaFields = $post->postType->fields->location->enabled || $post->postType->fields->day->enabled || $post->postType->fields->time->enabled;

                    $showContent = $post->postType->options->showContentInTimelineView;

                    $post->loadMissing('characterAuthors', 'userAuthors');
                @endphp

                <x-feed.item :dot-color="$post->postType->color">
                    <div class="flex items-center gap-x-6">
                        <x-h2>{{ $post->title }}</x-h2>
                        <x-badge>{{ $post->postType->name }}</x-badge>
                    </div>

                    <div class="mt-1.5">
                        <x-feed.post-meta-fields
                            :post="$post"
                        ></x-feed.post-meta-fields>

                        @if ($showContent)
                            <div
                                @class([
                                    'prose prose-lg dark:prose-invert relative max-w-4xl',
                                    'mt-4' => $showMetaFields,
                                ])
                            >
                                {!! $post->content !!}
                            </div>
                        @endif

                        <div class="relative mt-4">
                            <div class="flex -space-x-2 overflow-hidden">
                                @foreach ($post->authors_avatars as $url)
                                    <img
                                        class="inline-block size-10 rounded-full bg-white ring-2 ring-white"
                                        src="{{ $url }}"
                                        alt=""
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-feed.post-meta-data
                                :post="$post"
                            ></x-feed.post-meta-data>
                        </div>

                        <div class="mt-8">
                            <x-public::button
                                :href="route('public.story-post', ['story' => $post->story, 'post' => $post])"
                            >
                                Read {{ str($post->postType->name)->lower() }}
                                <span aria-hidden="true">→</span>
                            </x-public::button>
                        </div>
                    </div>
                </x-feed.item>
            @endforeach
        </x-feed>
    @else
        <x-empty variant="jumbo">
            <x-illustration :name="Illustration::Book" />
            <x-empty.heading>No posts found</x-empty.heading>

            @if (blank($storyId))
                <x-empty.text>
                    Select a story to view the posts timeline
                </x-empty.text>
            @else
                <x-empty.text>There are no posts in this story</x-empty.text>
            @endif
        </x-empty>
    @endif
</x-spacing>
