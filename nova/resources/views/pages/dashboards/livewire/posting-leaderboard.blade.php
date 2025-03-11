@use('Nova\Settings\Enums\LeaderboardTimeframe')

<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-x-2">
            <x-icon :name="$settings->icon" size="md" class="text-gray-500"></x-icon>
            <x-h2>{{ $settings->title }}</x-h2>
        </div>

        <div class="flex items-center gap-x-2 text-sm">
            @if ($settings->userSelectableTimeframe)
                <x-select.subtle wire:model.live="timeframe">
                    @foreach (LeaderboardTimeframe::cases() as $t)
                        <option value="{{ $t->value }}">
                            {{ $t->getLabel() }}
                        </option>
                    @endforeach
                </x-select.subtle>
            @endif
        </div>
    </div>

    @if (filled($leaderboard))
        @if ($settings->showPodium)
            <div class="flex items-end gap-2">
                @foreach ($leaderboard->slice(0, 3) as $index => $user)
                    <div
                        @class([
                            'flex-1 space-y-2',
                            match ($loop->iteration) {
                                1 => 'order-2',
                                2 => 'order-1',
                                3 => 'order-3',
                            },
                        ])
                    >
                        <div class="flex flex-col items-center">
                            <x-avatar.user :$user size="xs"></x-avatar.user>
                            <x-text>{{ Number::format((int) $user->author_count) }}</x-text>
                        </div>
                        <div
                            @class([
                                'flex w-full flex-col items-center justify-center rounded-t-lg text-lg font-bold tabular-nums text-white',
                                match ($loop->iteration) {
                                    1 => 'h-24 bg-primary-500',
                                    2 => 'h-16 bg-primary-400',
                                    3 => 'h-8 bg-primary-300',
                                },
                            ])
                        >
                            {{ $index + 1 }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @php
            $leaderboardSliced = $settings->showPodium ? $leaderboard->slice(3) : $leaderboard;
        @endphp

        <dl>
            @foreach ($leaderboardSliced as $index => $user)
                <div
                    class="flex items-center justify-between rounded-md px-3 py-2 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                >
                    <dt
                        @class([
                            'flex items-center',
                            'gap-x-4' => $leaderboard->count() < 10,
                        ])
                    >
                        @if ($settings->showRankNumbers)
                            <div
                                @class([
                                    'text-sm/6 tabular-nums text-gray-500',
                                    'w-9' => $leaderboard->count() >= 10,
                                ])
                            >
                                {{ $index + 1 }}.
                            </div>
                        @endif

                        <x-avatar.user :$user size="xs"></x-avatar.user>
                    </dt>
                    <dd class="font-semibold tabular-nums text-gray-950 dark:text-white">
                        {{ Number::format((int) $user->author_count) }}
                    </dd>
                </div>
            @endforeach
        </dl>
    @else
        <x-empty-state variant="jumbo">
            <x-icon :name="$settings->icon"></x-icon>
            <x-h3>No data available</x-h3>
        </x-empty-state>
    @endif
</div>
