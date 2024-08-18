@use('Nova\Applications\Enums\ApplicationResult')
@use('Nova\Applications\Models\ApplicationReview')
@use('Nova\Foundation\Models\DiscussionMessage')

<div>
    @if ($application->result === ApplicationResult::Pending)
        <div class="flex items-start gap-x-4">
            <div class="min-w-0 flex-1">
                <form action="#" class="relative">
                    <div
                        class="overflow-hidden rounded-lg shadow-sm ring-1 ring-inset ring-gray-950/10 focus-within:ring-2 focus-within:ring-primary-500 dark:ring-white/10 dark:focus-within:ring-primary-500"
                    >
                        <label for="comment" class="sr-only">Add your message</label>
                        <textarea
                            rows="3"
                            class="block max-h-60 w-full resize-none border-0 bg-transparent py-1.5 text-gray-900 [field-sizing:content] placeholder:text-gray-400 focus:ring-0 dark:text-white dark:placeholder:text-gray-500 sm:text-sm sm:leading-6"
                            placeholder="Add a message to the application review"
                            wire:model.live="content"
                        ></textarea>

                        <!-- Spacer element to match the height of the toolbar -->
                        <div class="py-2" aria-hidden="true">
                            <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                            <div class="py-px">
                                <div class="h-9"></div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                        <div class="ml-auto shrink-0">
                            <x-button type="button" wire:click="addMessage" plain>
                                <x-icon name="send" size="sm"></x-icon>
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <ul @class([
        'grid grid-cols-1 space-y-6',
        'mt-8' => ApplicationResult::Pending,
    ])>
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
                                    :name="$application->result === ApplicationResult::Accept ? 'progress-check' : 'progress-x'"
                                    size="lg"
                                ></x-icon>
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

        @forelse ($messages->loadMissing('user') as $message)
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
                                        <x-icon :name="$accepted ? 'progress-check' : 'progress-x'" size="lg"></x-icon>
                                        <div class="text-base/7 font-semibold">
                                            {{ $message->user->name }} has voted to
                                            {{ str($message->result->getShortLabel())->lower() }} this application
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
                        <div class="font-medium text-gray-500 dark:text-gray-400">{{ $message->user->name }}</div>
                        <div>{{ $message->updated_at?->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        @empty
            @if ($application->result === ApplicationResult::Pending)
                <x-empty-state.small
                    icon="message-dots"
                    message="Go ahead, say something and get the conversation started."
                >
                    <x-slot name="title">No discussion messages</x-slot>
                </x-empty-state.small>
            @endif
        @endforelse
    </ul>
</div>
