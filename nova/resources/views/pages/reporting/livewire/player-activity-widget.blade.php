<x-panel variant="well">
    <x-panel.header title="Activity">
        <x-slot name="description">
            This provides insight into player activity for
            {{ settings('posting_activity')->timeframe->getStatsDescription() }}
        </x-slot>
    </x-panel.header>

    <x-panel>
        <x-spacing size="md" class="flex items-center justify-center gap-x-8">
            <x-progress.circular :percentage="$stats->percentage()" class="size-20"></x-progress.circular>
            <div>
                <h2 class="shrink-0 text-6xl font-extrabold tabular-nums tracking-tight text-gray-950 dark:text-white">
                    {{ $stats->percentage() }}%
                </h2>
                <div class="flex items-center gap-x-2">
                    <x-text>{{ $stats->active }} of {{ $stats->total }} users</x-text>
                    {!! $changeBadge !!}
                </div>
            </div>
        </x-spacing>
    </x-panel>

    @if ($showLink)
        <x-panel.footer>
            <x-button :href="route('admin.reporting.player-activity')" text>View the activity report &rarr;</x-button>
        </x-panel.footer>
    @endif
</x-panel>
