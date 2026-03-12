@use('Nova\Stories\Models\PostType')

<x-admin-layout>
    <x-page-heading heading="Game report">
        <x-slot name="description">
            An overview of the game for {{ $settings->timeframe->getStatsDescription() }}
        </x-slot>
    </x-page-heading>

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
                            <x-icon :name="Tabler::CircleCheck" size="lg" class="text-gray-500" />
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
                            <x-icon :name="Tabler::CircleDashed" size="lg" class="text-gray-500" />
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
                            <x-icon :name="Tabler::Abc" size="lg" class="text-gray-500" />
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
                        <x-icon :name="Tabler::Calendar" size="lg" />
                    </div>
                    <div>
                        <x-text>
                            <strong>Monthly summary</strong>
                        </x-text>
                        <x-text>A summary of activity for the current and previous months.</x-text>
                        <div class="mt-3">
                            <x-button :href="route('admin.reporting.game-stats')" variant="subtle" inset="left">
                                View summary
                                <span aria-hidden="true">→</span>
                            </x-button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-x-3">
                    <div class="shrink-0">
                        <x-icon :name="Tabler::ChartInfographic" size="lg" />
                    </div>
                    <div>
                        <x-text>
                            <strong>Game stats</strong>
                        </x-text>
                        <x-text>A summary of major metrics over the game’s lifetime.</x-text>
                        <div class="mt-3">
                            <x-button :href="route('admin.reporting.game-stats')" variant="subtle" inset="left">
                                View stats
                                <span aria-hidden="true">→</span>
                            </x-button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-x-3">
                    <div class="shrink-0">
                        <x-icon :name="Tabler::PencilCog" size="lg" />
                    </div>
                    <div>
                        <x-text>
                            <strong>Post types report</strong>
                        </x-text>
                        <x-text>A summary of post types and their stats for the game.</x-text>
                        <div class="mt-3">
                            <x-button :href="route('admin.reporting.post-types')" variant="subtle" inset="left">
                                View report
                                <span aria-hidden="true">→</span>
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-spacing>
    </div>
</x-admin-layout>
