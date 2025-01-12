@use('Illuminate\Support\Number')
@use('Nova\Foundation\Helpers\TimeHelper')
@use('Nova\Settings\Enums\PostingTarget')
@use('Nova\Stories\Models\Post')

<x-admin-layout>
    <x-page-header>
        @can('update', settings())
            <x-slot name="actions">
                <x-button :href="route('admin.settings.writing-dashboard.edit')">
                    <x-icon name="settings" size="sm"></x-icon>
                    Dashboard settings
                </x-button>
            </x-slot>
        @endcan
    </x-page-header>

    <div class="space-y-12">
        <div class="grid auto-rows-fr grid-cols-5 gap-8">
            <x-panel class="col-span-2 flex items-center">
                <x-spacing size="sm">
                    <div class="flex flex-col items-center gap-y-2">
                        <div class="relative">
                            <x-icon.gradient.laurel-wreath class="size-16"></x-icon.gradient.laurel-wreath>

                            <div
                                @class([
                                    'absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 font-mono font-semibold tracking-tighter text-gray-950 dark:text-white',
                                    match (true) {
                                        $currentPostingMilestone >= 1000 => 'text-base',
                                        $currentPostingMilestone >= 100 => 'text-lg',
                                        $currentPostingMilestone < 10 => 'text-xl',
                                        default => 'text-sm',
                                    },
                                ])
                            >
                                {{ $currentPostingMilestone }}
                            </div>
                        </div>

                        <x-h2>{{ auth()->user()->name }}</x-h2>
                    </div>

                    <div class="mt-6">
                        <div class="relative h-3 overflow-hidden rounded-full bg-gray-950/10 dark:bg-white/10">
                            <div
                                @class([
                                    'absolute h-3 rounded-full bg-primary-500 ring-2 ring-white dark:ring-gray-800',
                                    'w-3' => $postingLevelPercentage === 0,
                                ])
                                @style([
                                    "width:{$postingLevelPercentage}%" => $postingLevelPercentage > 0,
                                ])
                            ></div>
                        </div>
                        <div class="mt-1 flex justify-between px-0.5">
                            <x-text color="primary" class="font-medium">
                                {{ Number::format($currentPostingMilestoneValue) }} {{ $postingMilestoneLabel }}
                            </x-text>
                            <x-text>{{ Number::format($nextPostingMilestone) }}</x-text>
                        </div>
                    </div>
                </x-spacing>
            </x-panel>

            <x-panel class="flex items-center">
                <x-spacing size="sm">
                    <div class="flex flex-col items-center">
                        <x-progress.circular :percentage="$activityPercentage" class="size-20"></x-progress.circular>

                        <div class="mt-4 flex flex-col items-center">
                            <x-text>
                                <x-text.strong>{{ $activityInTimeframe }} / {{ $activityTarget }}</x-text.strong>
                            </x-text>
                            <x-text color="subtle">{{ $activityLabel }}</x-text>
                        </div>
                    </div>
                </x-spacing>
            </x-panel>

            <x-panel class="col-span-2 flex flex-col divide-y divide-gray-950/5 align-middle">
                <x-spacing size="sm">
                    <x-h5>
                        {{ settings('posting_activity.timeframe')->getStatsLabel() }}
                    </x-h5>

                    <div class="mt-2 flex flex-1 items-center">
                        <div class="flex-1">
                            <div class="flex items-center gap-x-2">
                                <p
                                    class="text-base font-semibold tabular-nums tracking-tight text-gray-900 dark:text-white"
                                >
                                    {{ $currentActivityTimeframe->formattedPosts() }}
                                </p>

                                @if ($currentActivityTimeframe->hasMetPostsRequirements())
                                    <x-icon.micro.check-circle
                                        class="size-4 text-success-500"
                                        x-tooltip.raw="Posting requirement met"
                                    ></x-icon.micro.check-circle>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Posts</p>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-x-2">
                                <p
                                    class="text-base font-semibold tabular-nums tracking-tight text-gray-900 dark:text-white"
                                >
                                    {{ $currentActivityTimeframe->formattedWords() }}
                                </p>

                                @if ($currentActivityTimeframe->hasMetWordsRequirements())
                                    <x-icon.micro.check-circle
                                        class="size-4 text-success-500"
                                        x-tooltip.raw="Posting requirement met"
                                    ></x-icon.micro.check-circle>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Words</p>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-semibold tabular-nums tracking-tight text-gray-900 dark:text-white"
                            >
                                {{ $currentActivityTimeframe->readingTime() }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Reading time</p>
                        </div>
                    </div>
                </x-spacing>
                <x-spacing size="sm">
                    <x-h5>Lifetime</x-h5>

                    <div class="mt-2 flex flex-1 items-center">
                        <div class="flex-1">
                            <p
                                class="text-base font-semibold tabular-nums tracking-tight text-gray-900 dark:text-white"
                            >
                                {{ $lifetime->formattedPosts() }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Posts</p>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-semibold tabular-nums tracking-tight text-gray-900 dark:text-white"
                            >
                                {{ $lifetime->formattedWords() }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Words</p>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-semibold tabular-nums tracking-tight text-gray-900 dark:text-white"
                            >
                                {{ $lifetime->readingTime() }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Reading time</p>
                        </div>
                    </div>
                </x-spacing>
            </x-panel>
        </div>

        <div class="grid grid-cols-5 gap-8">
            <div
                @class([
                    'col-span-3' => settings('writing_dashboard.leaderboard.enabled'),
                ])
            >
                <x-panel well>
                    <x-panel.well.header
                        title="My draft posts"
                        description="Drafts are posts in progress that have not been published."
                    >
                        @can('create', Post::class)
                            <x-slot name="controls">
                                <x-button :href="route('admin.posts.create')">
                                    <x-icon name="write" size="sm"></x-icon>
                                    Start writing
                                </x-button>
                            </x-slot>
                        @endcan
                    </x-panel.well.header>

                    <x-panel class="divide-y divide-gray-950/5 overflow-hidden">
                        @forelse ($drafts as $draft)
                            <x-spacing size="sm" class="group relative">
                                <div class="flex items-center justify-between">
                                    <div
                                        @class([
                                            'flex',
                                            'items-center' => ! $draft->has_location_and_time,
                                        ])
                                    >
                                        <div class="mr-2 shrink-0" style="color: {{ $draft->postType->color }}">
                                            <x-icon :name="$draft->postType->icon" size="lg"></x-icon>
                                        </div>

                                        <div class="flex flex-col gap-y-1">
                                            <div class="flex items-center gap-x-2">
                                                <x-text>
                                                    <x-text.strong>{{ $draft->title }}</x-text.strong>
                                                </x-text>

                                                @if ($draft->needs_attention)
                                                    <x-badge color="warning">Attention needed</x-badge>
                                                @endif
                                            </div>

                                            @if ($draft->has_location_and_time)
                                                <div class="flex items-center space-x-4">
                                                    @if (filled($draft->location))
                                                        <x-text size="sm">{{ $draft->location }}</x-text>
                                                    @endif

                                                    @if (filled($draft->time))
                                                        <x-text size="sm">{{ $draft->time }}</x-text>
                                                    @endif

                                                    @if (filled($draft->day))
                                                        <x-text size="sm">{{ $draft->day }}</x-text>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-x-2">
                                        @if ($draft->isLocked() && ! $draft->lockIsOwnedBy(auth()->user()))
                                            <x-badge color="warning">
                                                <x-icon.micro.lock-closed
                                                    class="size-3.5 shrink-0"
                                                ></x-icon.micro.lock-closed>
                                                <p>Locked for editing</p>
                                            </x-badge>
                                        @endif

                                        @if ($draft->isLocked() && $draft->lockIsOwnedBy(auth()->user()))
                                            <x-badge color="primary">
                                                <x-icon.micro.lock-closed
                                                    class="size-3.5 shrink-0"
                                                ></x-icon.micro.lock-closed>
                                                <p>Locked by you</p>
                                            </x-badge>
                                        @endif

                                        <div
                                            class="flex items-center text-gray-400 transition group-hover:text-gray-500 dark:text-gray-600 dark:group-hover:text-gray-500"
                                        >
                                            <x-icon name="chevron-right" size="sm"></x-icon>
                                        </div>
                                    </div>
                                </div>

                                @can('update', $draft)
                                    <a href="{{ route('admin.posts.edit', $draft) }}" class="absolute inset-0"></a>
                                @endcan
                            </x-spacing>
                        @empty
                            <x-spacing size="md">
                                <x-empty-state>
                                    <x-icon name="write"></x-icon>
                                    <x-h3>No draft posts found</x-h3>
                                    <x-text>
                                        It looks like you don’t have any draft posts right now. Fire up a new post and
                                        start contributing!
                                    </x-text>

                                    @can('create', Post::class)
                                        <x-button :href="route('admin.posts.create')">
                                            <x-icon name="write" size="sm"></x-icon>
                                            Start writing
                                        </x-button>
                                    @endcan
                                </x-empty-state>
                            </x-spacing>
                        @endforelse
                    </x-panel>
                </x-panel>
            </div>

            @if (settings('writing_dashboard.leaderboard.enabled'))
                <div class="col-span-2">
                    <livewire:posting-leaderboard />
                </div>
            @endif
        </div>

        <div>
            <x-h2>Recently published posts</x-h2>
            <x-text>Posts that have been published in the last 30 days</x-text>

            <livewire:posts-recent-published-posts-list />
        </div>
    </div>
</x-admin-layout>
