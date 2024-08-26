@extends($meta->template)

@use('Illuminate\Support\Number')

@section('content')
    <div class="@container advanced-page story-details">
        @if ($story->hasMedia('story-image'))
            <img src="{{ $story->getFirstMediaUrl('story-image') }}" alt="" class="story-image" />
        @endif

        <div class="story-details-ctn">
            <div class="story-title">
                <x-public::h2>{{ $story->title }}</x-public::h2>

                <x-badge :color="$story->status->color()" size="md">
                    {{ $story->status->displayName() }}
                </x-badge>
            </div>

            <x-public::tabs initial="info">
                <x-slot name="tabs">
                    <x-public::tabs.tab name="info">Info</x-public::tabs.tab>

                    @if ($story->has_summary)
                        <x-public::tabs.tab name="summary">Summary</x-public::tabs.tab>
                    @endif

                    <x-public::tabs.tab name="posts">Posts</x-public::tabs.tab>
                </x-slot>

                <x-public::tabs.pane class="details-columns" x-show="isTab('info')" x-cloak>
                    <div class="main-column">
                        <div class="metadata">
                            @if ($story->started_at)
                                <div class="metadata-item">
                                    @if (blank($story->ended_at))
                                        <div class="metadata-item-leading">Started on</div>
                                    @endif

                                    <div class="metadata-item-label">
                                        {{ format_date($story->started_at, false) }}
                                        @if ($story->ended_at)
                                            &ndash;
                                            {{ format_date($story->ended_at) }}
                                        @endif
                                    </div>
                                </div>

                                <div class="metadata-item">
                                    @php($daysRunning = $story->started_at->diffInDays($story->ended_at ?? now()))
                                    <div class="metadata-item-leading">
                                        {{ trans_choice('Running for|Ran for', blank($story->ended_at)) }}
                                    </div>
                                    <div class="metadata-item-label">
                                        {{ number_format($daysRunning) }} {{ str('day')->plural($daysRunning) }}
                                    </div>
                                </div>
                            @endif

                            @if ($ancestors->count() > 0)
                                <a href="{{ route('public.story', $ancestors->last()) }}" class="metadata-item">
                                    <div class="metadata-item-leading">Part of</div>
                                    <div class="metadata-item-label">
                                        {{ $ancestors->last()->title }}
                                    </div>
                                </a>
                            @endif
                        </div>

                        <x-public::lead markdown>
                            {{ $story->description }}
                        </x-public::lead>
                    </div>

                    <div class="secondary-column">
                        <dl class="stats-container">
                            <div class="stat">
                                <dt>Total posts</dt>
                                <dd>
                                    {{ Number::format($story->posts_count) }}
                                </dd>
                            </div>
                            <div class="stat">
                                <dt>Total words</dt>
                                <dd>
                                    {{ Number::format($story->posts_sum_word_count ?? 0) }}
                                </dd>
                            </div>

                            @if ($story->children->count() > 0)
                                <div class="stat">
                                    <dt>Total posts (all stories within)</dt>
                                    <dd>
                                        {{ Number::format($story->recursive_posts_count) }}
                                    </dd>
                                </div>
                                <div class="stat">
                                    <dt>Total words (all stories within)</dt>
                                    <dd>
                                        {{ Number::format($story->recursive_posts_sum_word_count ?? 0) }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </x-public::tabs.pane>

                <x-public::tabs.pane x-show="isTab('summary')" x-cloak>
                    <x-public::lead markdown>
                        {{ $story->summary }}
                    </x-public::lead>
                </x-public::tabs.pane>

                <x-public::tabs.pane x-show="isTab('posts')" x-cloak>
                    <livewire:public-posts-timeline :story="$story" />
                </x-public::tabs.pane>
            </x-public::tabs>
        </div>
    </div>
@endsection
