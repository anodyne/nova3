@use('Nova\Applications\Enums\ApplicationResult')

<div class="flex flex-col gap-8">
    <div class="space-y-1">
        <x-heading size="lg">Application review</x-heading>
        <x-text>Leave your review of the application for others to see and contribute to the overall decision.</x-text>
    </div>

    <div class="flex flex-col gap-2">
        <x-heading>Reviewers</x-heading>

        <ul>
            @foreach ($application->reviews as $review)
                <li
                    class="flex items-center justify-between rounded-lg px-3 py-1 text-sm/6 font-medium odd:bg-gray-100 dark:odd:bg-gray-900"
                >
                    <div>{{ $review->name }}</div>

                    @if (settings('applications.alwaysShowResults') || ! settings('applications.alwaysShowResults') && $currentUserHasReviewed)
                        <div
                            @class([
                                'size-2 rounded-full',
                                'bg-success-500' => $review->pivot->result === ApplicationResult::Accept,
                                'bg-danger-500' => $review->pivot->result === ApplicationResult::Deny,
                                'bg-gray-300 dark:bg-gray-700' => blank($review->pivot->result),
                            ])
                        ></div>
                    @endif
                </li>
            @endforeach
        </ul>

        @can('decide', $application)
            <div class="flex items-center px-3 py-1">
                <x-button
                    wire:click="$dispatch('modal-open', {modal: 'application-reviewers-modal', props: {'application': {{ $application->id }}}})"
                    variant="ghost"
                    inset="left"
                >
                    Manage reviewers
                    <span aria-hidden="true">→</span>
                </x-button>
            </div>
        @endcan
    </div>

    @if (settings('applications.alwaysShowResults') || ! settings('applications.alwaysShowResults') && $currentUserHasReviewed)
        <div class="flex h-2.5 gap-0.5 overflow-hidden rounded-full">
            @if ($application->accepted_reviews_count > 0)
                <div
                    class="bg-success-500"
                    style="width: {{ ($application->accepted_reviews_count / $application->reviews_count) * 100 }}%"
                ></div>
            @endif

            @if ($application->no_result_reviews_count > 0)
                <div class="flex-1 bg-gray-300 dark:bg-gray-700"></div>
            @endif

            @if ($application->denied_reviews_count > 0)
                <div
                    class="bg-danger-500"
                    style="width: {{ ($application->denied_reviews_count / $application->reviews_count) * 100 }}%"
                ></div>
            @endif
        </div>
    @endif

    @if ($application->result === ApplicationResult::Pending)
        <div>
            @can('vote', $application)
                <x-button
                    wire:click="$dispatch('modal-open', {modal: 'application-review-modal', props: {'application': {{ $application->id }}, 'user': {{ auth()->id() }}}})"
                    class="w-full"
                >
                    {{ $currentUserHasReviewed ? 'Update review' : 'Add review' }}
                </x-button>
            @endcan

            @cannot('vote', $application)
                <x-text>
                    Your review has been recorded, but admins do not allow changing your review after submitting it.
                </x-text>
            @endcannot
        </div>
    @endif

    @can('decide', $application)
        <div>
            <x-button
                wire:click="$dispatch('modal-open', {modal: 'application-decision-modal', props: {'application': {{ $application->id }}}})"
                variant="primary"
                class="w-full"
            >
                Make final decision
            </x-button>
        </div>
    @endcan
</div>
