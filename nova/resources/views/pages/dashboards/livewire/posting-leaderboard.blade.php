@use('Nova\Settings\Enums\LeaderboardTimeframe')

<div class="space-y-4">
    <div class="flex flex-col gap-2">
        <div class="flex items-center gap-2">
            <x-icon :name="$settings->icon" size="md" class="text-gray-500" />
            <x-heading size="lg" level="2">{{ $settings->title }}</x-heading>
        </div>

        <div class="flex items-center gap-2">
            @if ($settings->userSelectableTimeframe)
                <x-select size="sm" wire:model.live="timeframe">
                    @foreach (LeaderboardTimeframe::cases() as $t)
                        <option value="{{ $t->value }}">
                            {{ $t->getLabel() }}
                        </option>
                    @endforeach
                </x-select>
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
                            <x-text>
                                {{ Number::format((int) $user->author_count) }}
                            </x-text>
                        </div>
                        <div
                            @class([
                                'flex w-full flex-col items-center justify-center rounded-t-lg text-lg font-bold text-white tabular-nums',
                                match ($loop->iteration) {
                                    1 => 'bg-primary-500 h-24',
                                    2 => 'bg-primary-400 h-16',
                                    3 => 'bg-primary-300 h-8',
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
                    class="flex items-center justify-between rounded-md px-3 py-2 odd:bg-gray-100 dark:odd:bg-gray-900"
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
                                    'text-sm/6 text-gray-500 tabular-nums',
                                    'w-9' => $leaderboard->count() >= 10,
                                ])
                            >
                                {{ $index + 1 }}.
                            </div>
                        @endif

                        <x-avatar.user :$user></x-avatar.user>
                    </dt>
                    <dd class="font-semibold text-gray-950 tabular-nums dark:text-white">
                        {{ Number::format((int) $user->author_count) }}
                    </dd>
                </div>
            @endforeach
        </dl>
    @else
        <x-empty>
            <x-illustration :name="Illustration::LineBarChart" />
            <x-empty.heading>No data available</x-empty.heading>
        </x-empty>
    @endif
</div>
