@php
    $stats = $participation->currentActivityTimeframe();
@endphp

<x-admin-layout>
    <x-page-header :description="$settings->getParticipationDescription()"></x-page-header>

    <div class="grid gap-8 lg:grid-cols-2">
        <div>
            <livewire:widget-player-participation
                :stats="$stats"
                :change-badge="$participation->percentageChangeBadge()"
            />
        </div>

        <div>
            <ul>
                @foreach ($stats->results as $user)
                    <li class="rounded-md px-3 py-1.5 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]">
                        <div class="flex items-center justify-between gap-x-3">
                            <div>
                                <div class="flex gap-x-2">
                                    @if ($user->total_word_count > 0)
                                        <x-icon name="check" size="md" class="text-success-500"></x-icon>
                                    @else
                                        <x-icon name="x-alt" size="md" class="text-danger-500"></x-icon>
                                    @endif

                                    <div class="font-semibold">{{ $user->name }}</div>
                                </div>
                            </div>

                            <div class="flex shrink-0 items-center gap-x-1 text-sm/6 tabular-nums">
                                {{ Number::format($user->total_word_count ?? 0) }}
                                {{ str('word')->plural($user->total_word_count ?? 0) }}
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-admin-layout>
