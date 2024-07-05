<x-panel well>
    @if (filled($conversation))
        <x-panel.well-heading :heading="$recipient?->name ?? 'New message'"></x-panel.well-heading>
    @endif

    <x-spacing size="2xs">
        <x-panel>
            @if (filled($conversationId))
                @if (filled($recipient))
                    <x-spacing size="md">
                        <ul class="grid grid-cols-1 space-y-6">
                            @forelse ($messages as $message)
                                @php($isMe = $message->author->is($me))

                                <div
                                    @class([
                                        'space-y-1',
                                        'place-self-start pe-16' => ! $isMe,
                                        'place-self-end ps-16' => $isMe,
                                    ])
                                >
                                    <div
                                        @class([
                                            'space-y-6 rounded-lg px-4 py-3 text-sm/6 font-medium',
                                            'bg-gray-100 dark:bg-gray-800' => ! $isMe,
                                            'bg-primary-100 text-primary-700 dark:bg-primary-950 dark:text-primary-500' => $isMe,
                                        ])
                                    >
                                        {!! str($message->content)->markdown() !!}
                                    </div>
                                    <div
                                        @class([
                                            'text-xs/5 text-gray-400 dark:text-gray-600',
                                            'ps-1' => ! $isMe,
                                            'pe-1 text-right' => $isMe,
                                        ])
                                    >
                                        {{ $message->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <x-empty-state.small
                                    icon="tabler-message-dots"
                                    message="Go ahead, say something and get the conversation started."
                                >
                                    <x-slot name="title">No message history with {{ $recipient?->name }}</x-slot>
                                </x-empty-state.small>
                            @endforelse
                        </ul>
                    </x-spacing>

                    <x-spacing size="md">
                        <div class="flex items-start space-x-4">
                            <div class="min-w-0 flex-1">
                                <form action="#" class="relative">
                                    <div
                                        class="overflow-hidden rounded-lg shadow ring-1 ring-gray-950/10 focus-within:ring-2 focus-within:ring-primary-500 dark:ring-white/10"
                                    >
                                        <label for="comment" class="sr-only">Add your message</label>
                                        <textarea
                                            rows="3"
                                            @class([
                                                'relative block h-full max-h-60 w-full resize-none appearance-none rounded-lg px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] [field-sizing:content] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)]',
                                                'text-base/6 text-gray-950 placeholder:text-gray-500 dark:text-white sm:text-sm/6',
                                                'border-0 bg-transparent focus:ring-0',
                                            ])
                                            placeholder="Message {{ $recipient?->name }}"
                                            wire:model.live.debounce="content"
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
                                        <div class="flex items-center space-x-5">
                                            <div class="flex items-center">
                                                <button
                                                    type="button"
                                                    class="-m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500"
                                                >
                                                    <svg
                                                        class="h-5 w-5"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    <span class="sr-only">Attach a file</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <x-button type="button" wire:click="sendMessage" plain>
                                                <x-icon name="send" size="sm"></x-icon>
                                            </x-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </x-spacing>
                @else
                    <x-spacing size="md">
                        <div class="relative flex max-w-md items-center">
                            <x-input.text placeholder="Type someone's name to get started"></x-input.text>
                        </div>
                    </x-spacing>
                @endif
            @else
                <div class="relative block w-full p-12 text-center">
                    <x-icon name="messages" size="2xl" class="mx-auto text-gray-400"></x-icon>
                    <span class="mt-2 block text-sm font-semibold text-gray-900">Pick a conversation</span>
                </div>
            @endif
        </x-panel>
    </x-spacing>
</x-panel>
