@use('Nova\Applications\Enums\ApplicationResult')
@use('Nova\Applications\Models\ApplicationReview')
@use('Nova\Discussions\Models\DiscussionMessage')

<div wire:poll.15s>
    @if ($application->result === ApplicationResult::Pending)
        <form wire:submit="addMessage">
            <x-composer
                wire:model="content"
                label="Message"
                label:sr-only
                rows="3"
                max-rows="10"
                placeholder="Add a message to the application review"
            >
                <x-slot name="actionsLeading"></x-slot>

                <x-slot name="actionsTrailing">
                    <x-button type="submit" size="sm" variant="filled">
                        Send
                    </x-button>
                </x-slot>
            </x-composer>
        </form>
    @endif

    <ul
        @class([
            'grid grid-cols-1 space-y-6',
            'mt-8' => ApplicationResult::Pending,
        ])
    >
        @if ($application->result !== ApplicationResult::Pending)
            <div class="space-y-1">
                <div
                    @class([
                        'space-y-6 rounded-lg text-sm/6 font-medium',
                        'bg-success-100 text-success-700 dark:bg-success-950 dark:text-success-500' => $application->result === ApplicationResult::Accept,
                        'bg-danger-100 text-danger-700 dark:bg-danger-950 dark:text-danger-500' => $application->result === ApplicationResult::Deny,
                    ])
                >
                    <div class="flex flex-col gap-y-2">
                        <x-spacing size="md">
                            <div class="flex items-center gap-x-3">
                                <x-icon
                                    :name="$application->result === ApplicationResult::Accept ? Tabler::ProgressCheck : Tabler::ProgressX"
                                    size="lg"
                                />
                                <div class="text-base/7 font-semibold">
                                    Application has been
                                    {{ str($application->result->getLabel())->lower() }}
                                </div>
                            </div>

                            @if (filled($application->decision_message))
                                <div class="mt-2 space-y-6">
                                    {!! str($application->decision_message)->markdown() !!}
                                </div>
                            @endif
                        </x-spacing>
                    </div>
                </div>

                <div
                    @class([
                        'flex items-center gap-x-6 ps-1 text-xs/5 text-gray-400 dark:text-gray-500',
                    ])
                >
                    <time datetime="{{ $application->decision_date }}">
                        {{ $application->decision_date?->diffForHumans() }}
                    </time>
                </div>
            </div>
        @endif

        @forelse ($messages as $message)
            @php
                $isMe = $message->user->is(auth()->user());
                $accepted = $message instanceof ApplicationReview && $message->result === ApplicationResult::Accept;
            @endphp

            <div
                @class([
                    'flex gap-x-4',
                    'place-self-start pe-32' => ! $isMe,
                    'flex-row-reverse place-self-end ps-32' => $isMe,
                ])
            >
                <div class="shrink-0">
                    <x-avatar :src="$message->user->avatar_url"></x-avatar>
                </div>

                <div class="space-y-1">
                    <div
                        @class([
                            'space-y-6 rounded-lg text-sm/6 font-medium',
                            'bg-gray-100 dark:bg-gray-800' => ! $isMe && $message instanceof DiscussionMessage,
                            'bg-primary-100 text-primary-700 dark:bg-primary-950 dark:text-primary-500' => $isMe && $message instanceof DiscussionMessage,
                            'bg-success-100 text-success-700 dark:bg-success-950 dark:text-success-500' => $message instanceof ApplicationReview && $accepted,
                            'bg-danger-100 text-danger-700 dark:bg-danger-950 dark:text-danger-500' => $message instanceof ApplicationReview && ! $accepted,
                        ])
                    >
                        @if ($message instanceof DiscussionMessage)
                            <x-spacing size="md" class="space-y-6">
                                {!! str($message->content)->markdown() !!}
                            </x-spacing>
                        @else
                            <div class="flex flex-col gap-y-2" x-data="{ expanded: false }">
                                <x-spacing size="md">
                                    <div class="flex items-center gap-x-3">
                                        <x-icon
                                            :name="$accepted ? Tabler::ProgressCheck : Tabler::ProgressX"
                                            size="lg"
                                        />
                                        <div class="text-base/7 font-semibold">
                                            {{ $message->user->name }} has voted to
                                            {{ str($message->result->getShortLabel())->lower() }}
                                            this application
                                        </div>
                                    </div>

                                    @if (filled($message->comments))
                                        <div class="mt-2 space-y-6">
                                            {!! str($message->comments)->markdown() !!}
                                        </div>
                                    @endif

                                    @if ($hasPublishedForm)
                                        <div class="mt-6">
                                            <button
                                                @class([
                                                    'rounded-full px-3 py-1 text-xs/5 font-semibold',
                                                    'bg-success-200 text-success-700 dark:bg-success-900 dark:text-success-500' => $accepted,
                                                    'bg-danger-200 text-danger-700 dark:bg-danger-900 dark:text-danger-500' => ! $accepted,
                                                ])
                                                x-on:click="expanded = !expanded"
                                            >
                                                <span x-show="expanded" x-cloak>
                                                    Hide the application review form responses &uarr;
                                                </span>
                                                <span x-show="!expanded">
                                                    Show the application review form responses &darr;
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                </x-spacing>

                                <x-spacing size="2xs" x-show="expanded" x-collapse x-cloak>
                                    <x-panel>
                                        <x-spacing size="sm">
                                            <livewire:dynamic-form
                                                :form="$applicationReviewForm"
                                                :submission="$message->formSubmission()"
                                                :admin="true"
                                                :static="true"
                                            ></livewire:dynamic-form>
                                        </x-spacing>
                                    </x-panel>
                                </x-spacing>
                            </div>
                        @endif
                    </div>

                    <div
                        @class([
                            'flex items-center gap-x-6 text-xs/5 text-gray-400 dark:text-gray-500',
                            'ps-1' => ! $isMe,
                            'flex-row-reverse pe-1 text-right' => $isMe,
                        ])
                    >
                        <div class="font-medium text-gray-500 dark:text-gray-400">
                            {{ $message->user->name }}
                        </div>
                        <div>{{ $message->updated_at?->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        @empty
            @if ($application->result === ApplicationResult::Pending)
                <x-empty>
                    <x-illustration :name="Illustration::BubbleDiscuss"/>
                    <x-empty.heading>No message history</x-empty.heading>
                    <x-empty.text>Go ahead, say something and get the conversation started.</x-empty.text>
                </x-empty>
            @endif
        @endforelse
    </ul>
</div>
