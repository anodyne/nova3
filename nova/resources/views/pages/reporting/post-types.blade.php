@use('Illuminate\Support\Number')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="description">
                This provides insight into post type utilization for
                {{ settings('posting_activity')->timeframe->getStatsDescription() }}
            </x-slot>
        </x-page-header>

        <div class="relative w-full flex-1 space-y-8 leading-normal">
            @foreach ($report->results as $postType)
                <div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0" style="color: {{ $postType->color }}">
                            <x-icon :name="$postType->icon" size="md"></x-icon>
                        </div>
                        <x-h3>{{ $postType->name }}</x-h3>
                    </div>

                    <div class="mt-3 *:rounded-md *:px-3 *:py-1.5">
                        <div class="flex items-center justify-between odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]">
                            <x-text><x-text.strong>Total published posts</x-text.strong></x-text>
                            <div class="font-medium tabular-nums tracking-tight">
                                {{ Number::format((int) $postType->published_posts_count) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-between odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]">
                            <x-text><x-text.strong>Total draft posts</x-text.strong></x-text>
                            <div class="font-medium tabular-nums tracking-tight">
                                {{ Number::format((int) $postType->draft_posts_count) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-between odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]">
                            <x-text><x-text.strong>Total post words</x-text.strong></x-text>
                            <div class="font-medium tabular-nums tracking-tight">
                                {{ Number::format((int) $postType->published_posts_sum_word_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-spacing>
</x-admin-layout>
