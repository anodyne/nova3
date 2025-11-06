<x-admin-layout>
    <x-page-heading></x-page-heading>

    <div>
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
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0">
                                            <x-avatar size="xl" :src="auth()->user()->avatar_url" />
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Welcome back,</div>
                                            <x-h1>
                                                {{ auth()->user()->name }}
                                            </x-h1>
                                        </div>
                                    </div>

                                    <div class="mt-5 md:mt-0">
                                        <div
                                            @class([
                                                'flex items-center gap-x-2 rounded-full bg-gradient-to-b from-white py-1 pr-1 pl-3.5 shadow ring-1 ring-inset dark:from-gray-950',
                                                'to-success-50 dark:to-success-950 text-success-600 dark:text-success-400 shadow-success-600/10 ring-success-600/20 dark:ring-success-900' => $activityPercentage >= 100,
                                                'to-warning-50 dark:to-warning-950 text-warning-600 dark:text-warning-400 shadow-warning-600/10 ring-warning-600/20 dark:ring-warning-900' => $activityPercentage > 25 && $activityPercentage < 100,
                                                'to-danger-50 dark:to-danger-950 text-danger-600 dark:text-danger-400 shadow-danger-600/10 ring-danger-600/20 dark:ring-danger-900' => $activityPercentage <= 25,
                                            ])
                                        >
                                            <div class="flex items-center gap-x-4 text-sm/6 font-medium">
                                                {{ $activityStatement }}
                                            </div>

                                            <div class="shrink-0">
                                                @if ($activityPercentage >= 100)
                                                    <x-icon :name="Tabler::CircleCheckFilled" size="size-7" />
                                                @else
                                                    <x-icon :name="Tabler::AlertCircleFilled" size="size-7" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-spacing>
                        </x-panel>

                        <x-panel.footer>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <x-button :href="route('admin.account.edit')" variant="ghost" inset="top bottom">
                                    <x-icon :name="Tabler::UserCircle" size="sm" />
                                    My account
                                </x-button>

                                <x-button
                                    :href="route('admin.characters.index', ['only_my_characters' => true])"
                                    variant="ghost"
                                    inset="top bottom"
                                >
                                    <x-icon :name="Tabler::MasksTheater" size="sm" />
                                    My characters
                                </x-button>

                                <x-button :href="route('admin.messages.index')" variant="ghost" inset="top bottom">
                                    <x-icon :name="Tabler::Inbox" size="sm" />
                                    My messages
                                    @if ($unreadMessagesCount = auth()->user()->unread_messages_count > 0)
                                        <x-badge color="primary" type="square">
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
                        class="group to-primary-50 dark:to-primary-950 ring-primary-500 dark:ring-primary-700 hover:shadow-primary-500/25 hover:ring-primary-400 dark:hover:ring-primary-600 relative rounded-xl bg-gradient-to-b from-white via-white ring-2 transition ring-inset hover:shadow-lg dark:from-gray-950 dark:via-gray-950"
                    >
                        <div class="absolute top-0 left-4 -translate-y-1/2">
                            <label
                                class="bg-primary-500 dark:bg-primary-700 group-hover:bg-primary-400 dark:group-hover:bg-primary-600 rounded-lg px-2.5 py-1 text-sm/5 font-medium text-white ring-4 ring-white dark:ring-gray-950"
                            >
                                {{ $firstOnboarding->ctaLabel }}
                            </label>
                        </div>

                        <x-spacing width="sm" height="md" class="space-y-4">
                            <div class="divide-y divide-gray-950/5 dark:divide-white/10">
                                @foreach ($activeOnboardings as $resource)
                                    <div class="flex items-start justify-between gap-8 py-3">
                                        <div>
                                            <x-heading size="lg" level="3">
                                                {{ $resource->label }}
                                            </x-heading>
                                            <x-text>
                                                {{ $resource->description }}
                                            </x-text>
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

                <livewire:posts-recent-published-posts-list />
            </div>

            <!-- Right column -->
            <div class="grid grid-cols-1 gap-12" data-tour="dashboard-writing-overview">
                <x-spacing width="2xs" data-tour="dashboard-writing-level">
                    <div class="flex flex-col items-center gap-y-2">
                        <div class="relative">
                            <x-icon.gradient.laurel-wreath class="size-16"></x-icon.gradient.laurel-wreath>

                            <div
                                @class([
                                    'absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 font-mono font-semibold tracking-tighter text-gray-950 dark:text-white',
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
                        <x-progress :percentage="$postingLevelPercentage" size="md" />

                        <div class="mt-1 flex justify-between px-0.5">
                            <x-text color="primary" class="font-medium">
                                {{ Number::format($currentPostingMilestoneValue) }}
                                {{ $postingMilestoneLabel }}
                            </x-text>
                            <x-text>
                                {{ Number::format($nextPostingMilestone) }}
                            </x-text>
                        </div>
                    </div>
                </x-spacing>

                <div class="space-y-8" data-tour="dashboard-writing-stats">
                    <div class="flex items-center gap-x-2">
                        <x-icon :name="Tabler::ChartInfographic" size="md" class="text-gray-500" />
                        <x-heading size="lg" level="2">My Contributions</x-heading>
                    </div>

                    <x-spacing width="2xs">
                        <x-h5>
                            {{ settings('posting_activity.timeframe')->getStatsLabel() }}
                        </x-h5>

                        <div class="mt-2 flex flex-1 items-center">
                            <div class="flex-1">
                                <div class="flex items-center gap-x-2">
                                    <p
                                        class="text-base font-semibold tracking-tight text-gray-900 tabular-nums dark:text-white"
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
                                        class="text-base font-semibold tracking-tight text-gray-900 tabular-nums dark:text-white"
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
                                    class="text-base font-semibold tracking-tight text-gray-900 tabular-nums dark:text-white"
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
                                    class="text-base font-semibold tracking-tight text-gray-900 tabular-nums dark:text-white"
                                >
                                    {{ $lifetime->formattedPosts() }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Posts</p>
                            </div>
                            <div class="flex-1">
                                <p
                                    class="text-base font-semibold tracking-tight text-gray-900 tabular-nums dark:text-white"
                                >
                                    {{ $lifetime->formattedWords() }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Words</p>
                            </div>
                            <div class="flex-1">
                                <p
                                    class="text-base font-semibold tracking-tight text-gray-900 tabular-nums dark:text-white"
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
