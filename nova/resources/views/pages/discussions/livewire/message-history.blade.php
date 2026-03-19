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
            <x-link role="button" wire:click="$parent.clearSelected()">
                <span aria-hidden="true">←</span>
                Back to messages
            </x-link>
        </div>
    </div>

    @if (filled($discussionId) && filled($discussion))
        <x-panel variant="well">
            <x-panel.header :title="$discussion->subject ?? '(No subject)'">
                <x-slot name="description">
                    <div class="mt-1 flex items-center gap-x-6">
                        @foreach ($discussion->allParticipants as $user)
                            <x-avatar.user :$user size="xs"></x-avatar.user>
                        @endforeach
                    </div>
                </x-slot>
            </x-panel.header>

            @if (filled($latestMessage))
                <x-panel>
                    <x-spacing size="row" class="flex items-center justify-between">
                        <x-avatar
                            :src="$latestMessage->user?->avatar_url"
                            size="sm"
                            :title="$latestMessage->user?->name"
                            :subtitle="DateHelper::formatShortDateWithTime($latestMessage->created_at)"
                        />

                        <div class="flex items-center gap-2">
                            @can('leave', $discussion)
                                <x-dropdown placement="bottom end">
                                    <x-slot name="trigger">
                                        <x-button variant="ghost" square>
                                            <x-icon :name="Tabler::DoorExit" size="sm" />
                                        </x-button>
                                    </x-slot>

                                    <x-dropdown.group>
                                        <x-dropdown.text>
                                            Are you sure you want to leave this group message?
                                        </x-dropdown.text>
                                    </x-dropdown.group>
                                    <x-dropdown.group>
                                        <x-dropdown.item
                                            type="button"
                                            :icon="Tabler::DoorExit"
                                            wire:click="leaveDiscussion"
                                            variant="danger"
                                        >
                                            Leave
                                        </x-dropdown.item>
                                        <x-dropdown.item
                                            type="button"
                                            :icon="Tabler::Ban"
                                            x-on:click.prevent="$dispatch('dropdown-close')"
                                        >
                                            Cancel
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                </x-dropdown>
                            @endcan

                            @can('delete', $discussion)
                                <x-dropdown placement="bottom end">
                                    <x-slot name="trigger">
                                        <x-button variant="ghost" square>
                                            <x-icon :name="Tabler::MessageOff" size="sm" />
                                        </x-button>
                                    </x-slot>

                                    <x-dropdown.group>
                                        <x-dropdown.text>
                                            Are you sure you want to remove this message from the conversation?
                                        </x-dropdown.text>
                                    </x-dropdown.group>
                                    <x-dropdown.group>
                                        <x-dropdown.item
                                            type="button"
                                            :icon="Tabler::MessageOff"
                                            wire:click="deleteMessage({{ $latestMessage }})"
                                            variant="danger"
                                        >
                                            Remove
                                        </x-dropdown.item>
                                        <x-dropdown.item
                                            type="button"
                                            :icon="Tabler::Ban"
                                            x-on:click.prevent="$dispatch('dropdown-close')"
                                        >
                                            Cancel
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                </x-dropdown>

                                <x-dropdown placement="bottom end">
                                    <x-slot name="trigger">
                                        <x-button variant="ghost" square data-danger>
                                            <x-icon :name="Tabler::Trash" size="sm" />
                                        </x-button>
                                    </x-slot>

                                    <x-dropdown.group>
                                        <x-dropdown.text>
                                            Are you sure you want to delete this entire conversation?
                                        </x-dropdown.text>
                                    </x-dropdown.group>
                                    <x-dropdown.group>
                                        <x-dropdown.item type="button" :icon="Tabler::Trash" wire:click="deleteDiscussion">
                                            Delete
                                        </x-dropdown.item>
                                        <x-dropdown.item
                                            type="button"
                                            :icon="Tabler::Ban"
                                            x-on:click.prevent="$dispatch('dropdown-close')"
                                        >
                                            Cancel
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                </x-dropdown>
                            @endcan
                        </div>
                    </x-spacing>

                    <x-spacing width="md" top="xs" bottom="md">
                        <div class="prose dark:prose-invert max-w-none space-y-6">
                            {!! str($latestMessage->content)->markdown() !!}
                        </div>
                    </x-spacing>
                </x-panel>
            @else
                <x-panel>
                    <x-empty>
                        <x-illustration :name="Illustration::Inbox" />
                        <x-empty.heading>No messages yet</x-empty.heading>
                        <x-empty.text>Send the first message in this conversation.</x-empty.text>
                    </x-empty>
                </x-panel>
            @endif

            <x-panel.footer class="flex items-center justify-between">
                <x-button
                    type="button"
                    wire:click="$dispatch('modal.open', {component: 'discussions-compose-message-modal', arguments: {'discussionId': {{ $discussion->id }}, 'mode': 'reply'}})"
                    :loading="false"
                    variant="subtle"
                    inset="left top bottom"
                >
                    <x-icon :name="Tabler::MessageReply" size="sm" />
                    Reply
                </x-button>
            </x-panel.footer>
        </x-panel>

        @if ($remainingMessages->count() > 0)
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-950/10 dark:border-white/10"></div>
                </div>
                <div class="relative flex justify-center">
                    <button
                        type="button"
                        class="relative inline-flex items-center gap-x-1.5 rounded-full bg-white px-2 py-1.5 text-sm font-medium text-gray-900 shadow-sm ring-1 ring-gray-950/10 ring-inset hover:bg-gray-50 dark:bg-gray-950 dark:text-white dark:ring-white/10 dark:before:absolute dark:before:inset-0 dark:before:rounded-full dark:before:bg-white/10 dark:hover:bg-gray-900"
                        wire:click="$toggle('remainingMessagesLoaded')"
                    >
                        <div
                            class="flex size-5 shrink-0 flex-col items-center justify-center rounded-full bg-gray-900 text-xs/5 text-white tabular-nums dark:bg-white dark:text-gray-950"
                        >
                            <div>
                                {{ $remainingMessages->count() }}
                            </div>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <span>Older messages</span>

                            @if ($remainingMessagesLoaded)
                                <x-icon.chevron-down class="size-4 text-gray-500 dark:text-gray-600" />
                            @else
                                <x-icon.chevron-right class="size-4 text-gray-500 dark:text-gray-600" />
                            @endif
                        </div>
                    </button>
                </div>
            </div>

            @if ($remainingMessagesLoaded)
                <div class="space-y-6">
                    @foreach ($remainingMessages as $message)
                        <x-panel variant="card" wire:key="{{ $message->id }}">
                            <x-spacing size="row" class="flex items-center justify-between">
                                <x-avatar
                                    :src="$message->user?->avatar_url"
                                    size="sm"
                                    :title="$message->user?->name"
                                    :subtitle="DateHelper::formatShortDateWithTime($message->created_at)"
                                />

                                @can('delete', $discussion)
                                    <div>
                                        <x-dropdown placement="bottom end">
                                            <x-slot name="trigger">
                                                <x-button
                                                    type="button"
                                                    variant="subtle"
                                                    inset="right top"
                                                    square
                                                    data-danger
                                                >
                                                    <x-icon :name="Tabler::MessageOff" size="sm" />
                                                </x-button>
                                            </x-slot>

                                            <x-dropdown.group>
                                                <x-dropdown.text>
                                                    Are you sure you want to remove this message from the conversation?
                                                </x-dropdown.text>
                                            </x-dropdown.group>
                                            <x-dropdown.group>
                                                <x-dropdown.item
                                                    type="button"
                                                    :icon="Tabler::MessageOff"
                                                    wire:click="deleteMessage({{ $message }})"
                                                    variant="danger"
                                                >
                                                    Remove
                                                </x-dropdown.item>
                                                <x-dropdown.item
                                                    type="button"
                                                    :icon="Tabler::Ban"
                                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                                >
                                                    Cancel
                                                </x-dropdown.item>
                                            </x-dropdown.group>
                                        </x-dropdown>
                                    </div>
                                @endcan
                            </x-spacing>

                            <x-spacing width="md" top="xs" bottom="md">
                                <div class="prose dark:prose-invert max-w-none space-y-6">
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
            <x-empty>
                <x-illustration :name="Illustration::Inbox" />
                <x-empty.heading>Select a conversation</x-empty.heading>
                <x-empty.text>Choose a conversation or start a new one</x-empty.text>

                <x-button
                    type="button"
                    variant="primary"
                    wire:click="$dispatch('modal.open', {component: 'discussions-compose-message-modal', arguments: {'mode': 'new'}})"
                >
                    Start a conversation
                </x-button>
            </x-empty>
        </div>
    @endif
</div>
