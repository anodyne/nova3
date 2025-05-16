<x-admin-layout>
    <x-page-header></x-page-header>

    <div>
        <section class="mb-8 hidden">
            <div
                @class([
                    'rounded-2xl',
                    'bg-[radial-gradient(ellipse_at_bottom,_var(--tw-gradient-stops))] from-primary-900 to-gray-900 text-white' => false,

                    'bg-gray-950 text-white',

                    'dark:bg-white dark:text-gray-950',
                ])
            >
                <x-spacing width="md" height="sm">
                    <div class="flex items-center justify-between gap-8">
                        <div class="flex-1">
                            <h2 class="text-2xl font-extrabold text-white dark:text-gray-950">
                                Welcome to {{ settings('general.gameName') }}
                            </h2>

                            <p class="text-sm/5 text-gray-400 dark:text-gray-600">
                                Let’s work on getting your account setup.
                            </p>
                        </div>
                        <div class="flex w-full max-w-xs items-center gap-4">
                            <div
                                class="relative h-3 w-full overflow-hidden rounded-full bg-white/25 dark:bg-gray-950/10"
                            >
                                <div
                                    @class([
                                        'absolute h-3 rounded-full bg-primary-500 ring-[3px] ring-gray-950 dark:ring-white',
                                        'w-3' => false,
                                    ])
                                    @style([
                                        'width:25%',
                                    ])
                                ></div>
                            </div>

                            <div class="flex items-center text-gray-500">
                                <x-icon.chevron-right class="size-6"></x-icon.chevron-right>
                            </div>
                        </div>
                    </div>

                    <div class="grid hidden grid-cols-1 gap-x-16 gap-y-8 xl:grid-cols-3">
                        <div class="flex flex-col justify-between">
                            <div>
                                <div
                                    class="inline-flex items-center rounded-full bg-primary-400/10 px-3 py-1 text-xs font-medium text-primary-400 ring-1 ring-inset ring-primary-400/20"
                                >
                                    Welcome to Nova 3
                                </div>
                            </div>
                            <div class="space-y-3">
                                <h2
                                    class="block font-[family-name:--font-header] text-xl/8 font-bold tracking-tight text-white dark:text-gray-900"
                                >
                                    Let’s get started
                                </h2>
                                <p class="text-sm/6">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, fugiat voluptatum! Rem
                                    molestias amet unde eligendi possimus tenetur! Impedit itaque corporis quis error
                                    ipsa exercitationem earum amet facere?
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2 h-60">foo</div>
                    </div>
                </x-spacing>
            </div>
        </section>

        <!-- Main 3 column grid -->
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
            <!-- Left column -->
            <div class="grid grid-cols-1 gap-12 lg:col-span-2">
                <!-- Welcome panel -->
                <section aria-labelledby="profile-overview-title">
                    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>

                    <x-panel variant="well">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="flex flex-col items-center gap-8 md:flex-row md:justify-between">
                                    <div class="flex items-center space-x-5">
                                        <div class="shrink-0">
                                            <x-avatar
                                                size="lg"
                                                :src="auth()->user()->avatar_url"
                                                :tooltip="auth()->user()->name"
                                            />
                                        </div>
                                        <div>
                                            <x-text>Welcome back,</x-text>
                                            <x-h1>{{ auth()->user()->name }}</x-h1>
                                        </div>
                                    </div>

                                    <div class="mt-5 md:mt-0">
                                        <div
                                            @class([
                                                'flex items-center gap-x-2 rounded-full bg-gradient-to-b from-white py-1 pl-3.5 pr-1 shadow ring-1 ring-inset',
                                                'to-success-50 text-success-600 shadow-success-600/10 ring-success-600/20' => $activityPercentage >= 100,
                                                'to-warning-50 text-warning-600 shadow-warning-600/10 ring-warning-600/20' => $activityPercentage > 25 && $activityPercentage < 100,
                                                'to-danger-50 text-danger-600 shadow-danger-600/10 ring-danger-600/20' => $activityPercentage <= 25,
                                            ])
                                        >
                                            <div class="flex items-center gap-x-4 text-sm/6 font-medium">
                                                {{ $activityStatement }}
                                            </div>

                                            <div class="shrink-0">
                                                @if ($activityPercentage >= 100)
                                                    <x-icon name="check-circle-filled" size="size-7"></x-icon>
                                                @else
                                                    <x-icon name="alert-filled" size="size-7"></x-icon>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-spacing>
                        </x-panel>

                        <x-panel.footer>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <x-button :href="route('admin.account.edit')" color="heavy-neutral" text>
                                    <x-icon name="user-profile" size="sm"></x-icon>
                                    My account
                                </x-button>

                                <x-button
                                    :href="route('admin.characters.index', ['only_my_characters' => true])"
                                    color="heavy-neutral"
                                    text
                                >
                                    <x-icon name="characters" size="sm"></x-icon>
                                    My characters
                                </x-button>

                                <x-button :href="route('admin.messages.index')" color="heavy-neutral" text>
                                    <x-icon name="inbox" size="sm"></x-icon>
                                    My messages
                                    @if ($unreadMessagesCount = auth()->user()->unread_messages_count > 0)
                                        <x-badge color="primary" class="tabular-nums">
                                            {{ $unreadMessagesCount }}
                                        </x-badge>
                                    @endif
                                </x-button>
                            </div>
                        </x-panel.footer>
                    </x-panel>
                </section>

                <!-- Onboarding panel -->
                @if ($activeOnboardings->count() > 0)
                    @php($firstOnboarding = $activeOnboardings->first())

                    <section
                        class="group relative rounded-xl bg-gradient-to-b from-white via-white to-primary-50 ring-2 ring-inset ring-primary-500 transition hover:shadow-lg hover:shadow-primary-500/25 hover:ring-primary-400"
                    >
                        <div class="absolute left-4 top-0 -translate-y-1/2">
                            <label
                                class="rounded-lg bg-primary-500 px-2 py-1 text-sm/5 font-medium text-white ring-4 ring-white group-hover:bg-primary-400"
                            >
                                {{ $firstOnboarding->ctaLabel }}
                            </label>
                        </div>

                        <x-spacing width="sm" height="md" class="space-y-4">
                            <div class="divide-y divide-gray-950/5">
                                @foreach ($activeOnboardings as $resource)
                                    <div class="flex items-start justify-between gap-8 py-3">
                                        <div>
                                            <x-h4>{{ $resource->label }}</x-h4>
                                            <x-text>{{ $resource->description }}</x-text>
                                        </div>
                                        <div class="flex w-1/4 items-center gap-2">
                                            <x-progress
                                                :percentage="$resource->percentComplete"
                                                color="primary"
                                            ></x-progress>
                                            <div class="text-xs/5 font-medium tabular-nums">
                                                {{ $resource->percentComplete }}%
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-spacing>

                        <a href="{{ route('admin.onboarding') }}" class="absolute inset-0"></a>
                    </section>
                @endif

                <div class="space-y-4">
                    <div>
                        <x-h2>Recently published posts</x-h2>
                        <x-text>Posts that have been published in the last 30 days</x-text>
                    </div>

                    <livewire:posts-recent-published-posts-list />
                </div>
            </div>

            <!-- Right column -->
            <div class="grid grid-cols-1 gap-12" data-tour="dashboard-writing-overview">
                <x-spacing width="2xs" data-tour="dashboard-writing-level">
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

                <div class="space-y-8" data-tour="dashboard-writing-stats">
                    <div class="flex items-center gap-x-2">
                        <x-icon name="chart-infographic" size="md" class="text-gray-500"></x-icon>
                        <x-h2>My Contributions</x-h2>
                    </div>

                    <x-spacing width="2xs">
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
                                            class="text-success-500"
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
                                            class="text-success-500"
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
                                    @if ($currentActivityTimeframe->words > 0)
                                        {{ $currentActivityTimeframe->readingTime() }}
                                    @else
                                        &mdash;
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Reading time</p>
                            </div>
                        </div>
                    </x-spacing>

                    <x-spacing width="2xs">
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
                                    @if ($lifetime->words > 0)
                                        {{ $lifetime->readingTime() }}
                                    @else
                                        &mdash;
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Reading time</p>
                            </div>
                        </div>
                    </x-spacing>
                </div>

                @if (settings('dashboard.leaderboard.enabled'))
                    <livewire:posting-leaderboard />
                @endif
            </div>
        </div>
    </div>

    <x-tips section="dashboard" />

    @push('scripts')
        <script src="{{ asset('dist/js/tour.js') }}"></script>
        <link href="{{ asset('dist/css/tour.css') }}" rel="stylesheet" />
    @endpush
</x-admin-layout>
