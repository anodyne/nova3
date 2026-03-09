@use('Nova\Settings\Enums\PostingTarget')

@php
    $stats = $activity->currentActivityTimeframe();

    $meetsRequirements = function ($user) use ($settings) {
        return match ($settings->target) {
            PostingTarget::Posts => $user->login_count > 0 && $user->published_post_count >= $settings->requirement,
            default => $user->login_count > 0 && $user->total_word_count >= $settings->requirement,
        };
    };
@endphp

<x-admin-layout>
    <x-page-heading :description="$settings->getActivityDescription()"></x-page-heading>

    <div class="grid gap-8 lg:grid-cols-2">
        <div>
            <livewire:widget-player-activity :stats="$stats" :change-badge="$activity->percentageChangeBadge()" />
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-x-6 text-sm/6 font-medium">
                <div class="flex items-center gap-x-1">
                    <x-icon :name="Tabler::CircleCheck" size="md" class="text-primary-500" />
                    <p>Published post</p>
                </div>
                <div class="flex items-center gap-x-1">
                    <x-icon :name="Tabler::CircleDashed" size="md" class="text-gray-500" />
                    <p>Draft post</p>
                </div>
                <div class="flex items-center gap-x-1">
                    <x-icon :name="Tabler::Abc" size="md" class="text-gray-500" />
                    <p>Post words</p>
                </div>
            </div>

            <ul>
                @foreach ($stats->results as $user)
                    <li class="rounded-md px-3 py-1.5 odd:bg-gray-950/5 dark:odd:bg-white/[.07]">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <div class="flex gap-x-2">
                                    @if ($meetsRequirements($user))
                                        <x-icon :name="Tabler::CircleCheck" size="md" class="text-success-500" />
                                    @else
                                        <x-icon :name="Tabler::CircleX" size="md" class="text-danger-500" />
                                    @endif

                                    <div>
                                        <div class="font-semibold">{{ $user->name }}</div>

                                        @if ($user->latest_login)
                                            <div class="text-xs/5 font-medium text-gray-500">
                                                Signed in
                                                {{ $user->latest_login?->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid shrink-0 grid-cols-3 gap-4 text-sm/6">
                                <div class="flex items-center gap-x-1 tabular-nums">
                                    <x-icon :name="Tabler::CircleCheck" size="md" class="text-primary-500" />
                                    {{ $user->published_post_count }}
                                </div>
                                <div class="flex items-center gap-x-1 tabular-nums">
                                    <x-icon :name="Tabler::CircleDashed" size="md" class="text-gray-500" />
                                    {{ $user->draft_post_count }}
                                </div>
                                <div class="flex items-center gap-x-1 tabular-nums">
                                    <x-icon :name="Tabler::Abc" size="md" class="text-gray-500" />
                                    {{ Number::format($user->total_word_count ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-admin-layout>
