@use('Illuminate\Support\Number')
@use('Nova\Stories\Models\PostType')

<x-admin-layout>
    <x-page-header heading="Game report">
        <x-slot name="description">
            An overview of the game for {{ $settings->timeframe->getStatsDescription() }}
        </x-slot>
    </x-page-header>

    <div class="space-y-12">
        <div class="grid gap-8 lg:grid-cols-2">
            <livewire:widget-player-participation
                :stats="$participation->currentActivityTimeframe()"
                :change-badge="$participation->percentageChangeBadge()"
                :show-link="true"
            />

            <livewire:widget-player-activity
                :stats="$activity->currentActivityTimeframe()"
                :change-badge="$activity->percentageChangeBadge()"
                :show-link="true"
            />
        </div>

        <x-panel variant="card">
            <x-spacing size="md">
                <x-h5>{{ $settings->timeframe->getStatsLabel() }}</x-h5>

                <div class="mt-4 grid gap-8 lg:grid-cols-3">
                    <div class="flex gap-x-3">
                        <div class="shrink-0">
                            <x-icon :name="Icon::CheckCircle" size="lg" class="text-gray-500"></x-icon>
                        </div>
                        <div>
                            <x-text size="lg">Published posts</x-text>

                            <h2
                                class="mt-2 shrink-0 text-4xl font-semibold tracking-tight text-gray-950 tabular-nums dark:text-white"
                            >
                                {{ Number::format($postingStats->published_post_count) }}
                            </h2>
                        </div>
                    </div>

                    <div class="flex gap-x-3">
                        <div class="shrink-0">
                            <x-icon :name="Icon::CircleDashed" size="lg" class="text-gray-500"></x-icon>
                        </div>
                        <div>
                            <x-text size="lg">Draft posts</x-text>

                            <h2
                                class="mt-2 shrink-0 text-4xl font-semibold tracking-tight text-gray-950 tabular-nums dark:text-white"
                            >
                                {{ Number::format($postingStats->draft_post_count) }}
                            </h2>
                        </div>
                    </div>

                    <div class="flex gap-x-3">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Abc" size="lg" class="text-gray-500"></x-icon>
                        </div>
                        <div>
                            <x-text size="lg">Post words</x-text>

                            <h2
                                class="mt-2 shrink-0 text-4xl font-semibold tracking-tight text-gray-950 tabular-nums dark:text-white"
                            >
                                {{ Number::format($postingStats->total_word_count ?? 0) }}
                            </h2>
                        </div>
                    </div>
                </div>
            </x-spacing>
        </x-panel>

        <x-spacing>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="flex gap-x-3">
                    <div class="shrink-0">
                        <x-icon :name="Icon::Calendar" size="lg"></x-icon>
                    </div>
                    <div>
                        <x-text>
                            <x-text.strong>Monthly summary</x-text.strong>
                        </x-text>
                        <x-text>A summary of activity for the current and previous months.</x-text>
                        <div class="mt-3">
                            <x-button :href="route('admin.reporting.game-stats')" color="heavy-neutral" text>
                                View summary &rarr;
                            </x-button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-x-3">
                    <div class="shrink-0">
                        <x-icon :name="Icon::ChartInfographic" size="lg"></x-icon>
                    </div>
                    <div>
                        <x-text>
                            <x-text.strong>Game stats</x-text.strong>
                        </x-text>
                        <x-text>A summary of major metrics over the game’s lifetime.</x-text>
                        <div class="mt-3">
                            <x-button :href="route('admin.reporting.game-stats')" color="heavy-neutral" text>
                                View stats &rarr;
                            </x-button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-x-3">
                    <div class="shrink-0">
                        <x-icon :name="Icon::EditSettings" size="lg"></x-icon>
                    </div>
                    <div>
                        <x-text>
                            <x-text.strong>Post types report</x-text.strong>
                        </x-text>
                        <x-text>A summary of post types and their stats for the game.</x-text>
                        <div class="mt-3">
                            <x-button :href="route('admin.reporting.post-types')" color="heavy-neutral" text>
                                View report &rarr;
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-spacing>
    </div>
</x-admin-layout>
