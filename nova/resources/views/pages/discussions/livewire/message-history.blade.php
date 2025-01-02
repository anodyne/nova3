@use('Nova\Discussions\Enums\MessageType')
@use('Nova\Foundation\Helpers\DateHelper')

<div class="space-y-8 lg:col-span-2">
    <div
        @class([
            'relative flex h-full flex-col lg:hidden',
            'max-md:hidden' => blank($discussionId),
        ])
    >
        <div>
            <x-button wire:click="$parent.clearSelected()" text>&larr; Back to messages</x-button>
        </div>
    </div>

    @if (filled($discussionId))
        <x-panel>
            <x-spacing height="sm" width="md" class="flex items-center justify-between">
                <div class="flex items-center gap-x-2">
                    <x-avatar :src="$latestMessage->user->avatar_url" size="sm"></x-avatar>
                    <div class="flex flex-col gap-y-0.5">
                        <x-text>
                            <x-text.strong>{{ $latestMessage->user->name }}</x-text.strong>
                        </x-text>
                        <x-text size="sm">
                            {{ DateHelper::formatShortDateWithTime($latestMessage->created_at) }}
                        </x-text>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    @can('delete', $discussion)
                        <x-dropdown placement="bottom-end">
                            <x-slot name="trigger" color="neutral-danger">
                                <x-icon name="message-off" size="sm"></x-icon>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to remove this message from the conversation?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item-danger
                                    type="button"
                                    icon="message-off"
                                    wire:click="deleteMessage({{ $latestMessage }})"
                                >
                                    Remove
                                </x-dropdown.item-danger>
                                <x-dropdown.item
                                    type="button"
                                    icon="prohibited"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>

                        <x-dropdown placement="bottom-end">
                            <x-slot name="trigger" color="neutral-danger">
                                <x-icon name="trash" size="sm"></x-icon>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to delete this entire conversation?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item-danger type="button" icon="trash" wire:click="deleteDiscussion">
                                    Delete
                                </x-dropdown.item-danger>
                                <x-dropdown.item
                                    type="button"
                                    icon="prohibited"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    @endcan
                </div>
            </x-spacing>
            <x-spacing size="md">
                <div class="prose max-w-none space-y-6 dark:prose-invert">
                    {!! str($latestMessage->content)->markdown() !!}
                </div>
            </x-spacing>
            <x-spacing
                height="sm"
                width="sm"
                class="dark:white/5 flex items-center justify-between rounded-b-lg border-t border-gray-950/5 bg-gray-950/[.03] dark:border-white/10"
            >
                <x-button
                    wire:click="$dispatch('openModal', { component: 'discussions-compose-message-modal', arguments: { discussionId: {{ $discussion->id }}, mode: 'reply' }})"
                    text
                >
                    <x-icon name="message-reply" size="sm"></x-icon>
                    Reply
                </x-button>

                @if ($discussion->is_group_message)
                    <x-button
                        wire:click="$dispatch('openModal', { component: 'discussions-compose-message-modal', arguments: { discussionId: {{ $discussion->id }}, mode: 'change-group-name' }})"
                        text
                    >
                        <x-icon name="form" size="sm"></x-icon>
                        Update group name
                    </x-button>
                @endif
            </x-spacing>
        </x-panel>

        @if ($remainingMessages->count() > 0)
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-950/10 dark:border-white/10"></div>
                </div>
                <div class="relative flex justify-center">
                    <button
                        type="button"
                        class="relative inline-flex items-center gap-x-1.5 rounded-full bg-white px-2 py-1.5 text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-950/10 hover:bg-gray-50 dark:bg-gray-950 dark:text-white dark:ring-white/10 dark:before:absolute dark:before:inset-0 dark:before:rounded-full dark:before:bg-white/10"
                        wire:click="$toggle('remainingMessagesLoaded')"
                    >
                        <div
                            class="flex size-5 shrink-0 flex-col items-center justify-center rounded-full bg-gray-900 text-xs/5 tabular-nums text-white dark:bg-white dark:text-gray-950"
                        >
                            <div>
                                {{ $remainingMessages->count() }}
                            </div>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <span>Older messages</span>

                            @if ($remainingMessagesLoaded)
                                <x-icon.chevron-down
                                    class="size-4 text-gray-500 dark:text-gray-600"
                                ></x-icon.chevron-down>
                            @else
                                <x-icon.chevron-right
                                    class="size-4 text-gray-500 dark:text-gray-600"
                                ></x-icon.chevron-right>
                            @endif
                        </div>
                    </button>
                </div>
            </div>

            @if ($remainingMessagesLoaded)
                <div class="space-y-6">
                    @foreach ($remainingMessages as $message)
                        <x-panel wire:key="{{ $message->id }}">
                            <x-spacing height="sm" width="md" class="flex items-center justify-between">
                                <div class="flex items-center gap-x-2">
                                    <x-avatar :src="$message->user->avatar_url" size="sm"></x-avatar>
                                    <div class="flex flex-col gap-y-0.5">
                                        <x-text>
                                            <x-text.strong>{{ $message->user->name }}</x-text.strong>
                                        </x-text>
                                        <x-text size="sm">
                                            {{ DateHelper::formatShortDateWithTime($message->created_at) }}
                                        </x-text>
                                    </div>
                                </div>

                                @can('delete', $discussion)
                                    <div>
                                        <x-dropdown placement="bottom-end">
                                            <x-slot name="trigger" color="neutral-danger">
                                                <x-icon name="message-off" size="sm"></x-icon>
                                            </x-slot>

                                            <x-dropdown.group>
                                                <x-dropdown.text>
                                                    Are you sure you want to remove this message from the conversation?
                                                </x-dropdown.text>
                                            </x-dropdown.group>
                                            <x-dropdown.group>
                                                <x-dropdown.item-danger
                                                    type="button"
                                                    icon="message-off"
                                                    wire:click="deleteMessage({{ $message }})"
                                                >
                                                    Remove
                                                </x-dropdown.item-danger>
                                                <x-dropdown.item
                                                    type="button"
                                                    icon="prohibited"
                                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                                >
                                                    Cancel
                                                </x-dropdown.item>
                                            </x-dropdown.group>
                                        </x-dropdown>
                                    </div>
                                @endcan
                            </x-spacing>
                            <x-spacing size="md">
                                <div class="prose max-w-none space-y-6 dark:prose-invert">
                                    {!! str($message->content)->markdown() !!}
                                </div>
                            </x-spacing>
                        </x-panel>
                    @endforeach
                </div>
            @endif
        @endif
    @else
        <div class="hidden lg:block">
            <x-empty-state variant="jumbo">
                <x-illustration name="empty-messages"></x-illustration>
                <x-h2>Select a conversation</x-h2>
                <x-text>Choose a conversation or start a new one</x-text>
                <x-button
                    type="button"
                    color="primary"
                    wire:click="$dispatch('openModal', { component: 'discussions-compose-message-modal', arguments: { mode: 'new' }})"
                >
                    Start a conversation
                </x-button>
            </x-empty-state>
        </div>
    @endif
</div>
