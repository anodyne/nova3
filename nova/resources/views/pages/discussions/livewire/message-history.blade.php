@use('Nova\Discussions\Enums\MessageType')

{{--
    <div @class([
    'flex-1 max-md:space-y-6',
    'max-md:hidden' => blank($discussionId),
    ])>
    
    </div>
--}}

<div class="flex h-full flex-1">
    {{-- Message view on desktop --}}
    <x-panel class="hidden h-full flex-1 flex-col overflow-auto lg:flex" well>
        @if (filled($discussion))
            <x-panel.well.header>
                <x-slot name="title">
                    @if (filled($discussion->name))
                        {{ $discussion->name }}
                    @else
                        @if (filled($participant))
                            <div class="flex items-center gap-x-4">
                                <div>{{ $participant?->name }}</div>

                                @if ($participant?->trashed())
                                    <x-badge color="danger">Deleted user</x-badge>
                                @else
                                    @if ($participant?->status->name() !== 'active')
                                        <x-badge :color="$participant?->status?->color()">
                                            {{ ucfirst($participant?->status?->name()) }}
                                        </x-badge>
                                    @endif
                                @endif
                            </div>
                        @else
                            New message
                        @endif
                    @endif
                </x-slot>

                @if (filled($participant))
                    <x-slot name="description">
                        Conversation began on {{ format_date($discussion->created_at) }}
                    </x-slot>
                @endif

                <x-slot name="controls">
                    <x-avatar.group :items="$discussion->participants" size="sm"></x-avatar.group>
                </x-slot>
            </x-panel.well.header>
        @endif

        <x-panel class="flex flex-1 flex-col overflow-auto">
            @if (filled($discussionId))
                <x-spacing class="flex-1 overflow-y-scroll" size="md">
                    <div
                        class="grid grid-cols-1 space-y-6"
                        x-init="document.getElementById('latestMessage').scrollIntoView()"
                    >
                        @forelse ($messages as $date => $messagesForDate)
                            @if (! $loop->first)
                                <x-discussion.system-message
                                    :content="$date"
                                    icon="calendar"
                                ></x-discussion.system-message>
                            @endif

                            @foreach ($messagesForDate as $message)
                                @if ($message->type === MessageType::System)
                                    <x-discussion.system-message
                                        :content="$message->content"
                                        :date="$message->created_at"
                                        icon="info"
                                    ></x-discussion.system-message>
                                @elseif ($message->type === MessageType::SystemDanger)
                                    <x-discussion.system-message
                                        :content="$message->content"
                                        :date="$message->created_at"
                                        icon="alert"
                                        variant="danger"
                                    ></x-discussion.system-message>
                                @else
                                    <x-discussion.message
                                        :content="$message->content"
                                        :author="! $discussion->is_direct_message ? $message->user->name : null"
                                        :date="$message->created_at"
                                        :mine="$message->user?->is($me)"
                                    ></x-discussion.message>
                                @endif
                            @endforeach
                        @empty
                            <x-empty-state.small
                                icon="tabler-message-dots"
                                message="Go ahead, say something and get the conversation started."
                            >
                                <x-slot name="title">No message history with {{ $participant?->name }}</x-slot>
                            </x-empty-state.small>
                        @endforelse
                    </div>

                    <div id="latestMessage" class="h-px"></div>
                </x-spacing>

                <x-spacing
                    class="sticky bottom-0 rounded-b-xl bg-gradient-to-t from-white via-white dark:from-gray-900 dark:via-gray-900"
                    size="md"
                >
                    <div class="flex items-start space-x-4">
                        <div class="min-w-0 flex-1">
                            <form
                                class="relative"
                                x-data="{
                                    shift: false,
                                }"
                                x-on:keydown.shift="shift = true"
                                x-on:keyup.shift="shift = false"
                                x-on:keydown.enter="
                                    if (! shift && ! $event.target.value) {
                                        $event.preventDefault()
                                    }

                                    if (! shift && $event.target.value) {
                                        $event.preventDefault()
                                        $wire.sendMessage()
                                    }
                                "
                            >
                                <x-fieldset.field name="content" id="content">
                                    <x-input.textarea
                                        rows="3"
                                        class="max-h-40 min-h-20 [field-sizing:content]"
                                        placeholder="Message {{ $discussion->is_direct_message ? $participant?->name : $discussion->name ?? 'group' }}"
                                        wire:model.live="content"
                                    ></x-input.textarea>

                                    <div
                                        class="text-base/6 text-gray-500 dark:text-gray-400 sm:text-sm/6"
                                        data-slot="help"
                                    >
                                        Enter to send a message, Shift + Enter for a new line
                                    </div>
                                </x-fieldset.field>
                            </form>
                        </div>
                    </div>
                </x-spacing>
            @else
                <x-spacing size="xl">
                    <x-empty-state>
                        <x-icon name="messages"></x-icon>
                        <x-text>
                            <x-text.strong>Pick a message</x-text.strong>
                        </x-text>
                    </x-empty-state>
                </x-spacing>
            @endif
        </x-panel>

        @if (filled($discussion))
            <x-panel.well.footer>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        @if (! $discussion->is_direct_message)
                            <x-button
                                wire:click="$dispatch('openModal', { component: 'discussions-compose-group-message-modal', arguments: { discussionId: {{ $discussion->id }}}})"
                                text
                            >
                                <x-icon name="preferences" size="sm"></x-icon>
                                Update settings
                            </x-button>
                        @endif
                    </div>

                    @if (! $discussion->is_direct_message)
                        <div class="flex items-center gap-6">
                            <x-dropdown placement="top-end">
                                <x-slot name="trigger" color="neutral">
                                    <x-icon name="logout" size="sm"></x-icon>
                                    Leave
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to leave this group message?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="logout" wire:click="leaveDiscussion">
                                        Leave
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
                    @else
                        <div class="flex items-center gap-6">
                            <x-dropdown placement="top-end">
                                <x-slot name="trigger" color="neutral">
                                    <x-icon name="trash" size="sm"></x-icon>
                                    Delete
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to delete this direct message?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="trash" wire:click="leaveDiscussion">
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
                        </div>
                    @endif
                </div>
            </x-panel.well.footer>
        @endif
    </x-panel>

    {{-- Message view on mobile --}}
    <div
        @class([
            'relative flex h-full flex-col lg:hidden',
            'max-md:hidden' => blank($discussionId),
        ])
    >
        <div class="mb-4">
            <x-button wire:click="$parent.clearSelected()" text>&larr; Back to messages</x-button>
        </div>

        @if (filled($discussion))
            <div class="pb-4">
                <div class="flex items-center justify-between gap-x-8">
                    <x-h2>
                        @if (filled($discussion->name))
                            {{ $discussion->name }}
                        @else
                            @if (filled($participant))
                                <div class="flex items-center gap-x-4">
                                    <div>{{ $participant?->name }}</div>

                                    @if ($participant?->trashed())
                                        <x-badge color="danger">Deleted user</x-badge>
                                    @else
                                        @if ($participant?->status->name() !== 'active')
                                            <x-badge :color="$participant?->status?->color()">
                                                {{ ucfirst($participant?->status?->name()) }}
                                            </x-badge>
                                        @endif
                                    @endif
                                </div>
                            @else
                                New message
                            @endif
                        @endif
                    </x-h2>

                    <div>
                        <x-avatar.group :items="$discussion->participants" size="sm"></x-avatar.group>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        @if (! $discussion->is_direct_message)
                            <x-button
                                wire:click="$dispatch('openModal', { component: 'discussions-compose-group-message-modal', arguments: { discussionId: {{ $discussion->id }}}})"
                                text
                            >
                                <x-icon name="preferences" size="sm"></x-icon>
                                Update settings
                            </x-button>
                        @endif
                    </div>

                    @if (! $discussion->is_direct_message)
                        <div class="flex items-center gap-6">
                            <x-dropdown placement="top-end">
                                <x-slot name="trigger" color="neutral">
                                    <x-icon name="logout" size="sm"></x-icon>
                                    Leave
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to leave this group message?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="logout" wire:click="leaveDiscussion">
                                        Leave
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
                    @else
                        <div class="flex items-center gap-6">
                            <x-dropdown placement="top-end">
                                <x-slot name="trigger" color="neutral">
                                    <x-icon name="trash" size="sm"></x-icon>
                                    Delete
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to delete this direct message?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="trash" wire:click="leaveDiscussion">
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
                        </div>
                    @endif
                </div>
            </div>

            <x-spacing class="flex-1 overflow-y-scroll" height="md">
                <div
                    class="grid grid-cols-1 space-y-6"
                    x-init="document.getElementById('latestMessageMobile').scrollIntoView()"
                >
                    @forelse ($messages as $date => $messagesForDate)
                        @if (! $loop->first)
                            <x-discussion.system-message
                                :content="$date"
                                icon="calendar"
                            ></x-discussion.system-message>
                        @endif

                        @foreach ($messagesForDate as $message)
                            @if ($message->type === MessageType::System)
                                <x-discussion.system-message
                                    :content="$message->content"
                                    :date="$message->created_at"
                                    icon="info"
                                ></x-discussion.system-message>
                            @elseif ($message->type === MessageType::SystemDanger)
                                <x-discussion.system-message
                                    :content="$message->content"
                                    :date="$message->created_at"
                                    icon="alert"
                                    variant="danger"
                                ></x-discussion.system-message>
                            @else
                                <x-discussion.message
                                    :content="$message->content"
                                    :author="! $discussion->is_direct_message ? $message->user->name : null"
                                    :date="$message->created_at"
                                    :mine="$message->user?->is($me)"
                                ></x-discussion.message>
                            @endif
                        @endforeach
                    @empty
                        <x-empty-state.small
                            icon="tabler-message-dots"
                            message="Go ahead, say something and get the conversation started."
                        >
                            <x-slot name="title">No message history with {{ $participant?->name }}</x-slot>
                        </x-empty-state.small>
                    @endforelse
                </div>

                <div id="latestMessageMobile" class="h-px"></div>
            </x-spacing>

            <div class="flex items-start space-x-4">
                <div class="min-w-0 flex-1">
                    <form
                        class="relative"
                        x-data="{
                            shift: false,
                        }"
                        x-on:keydown.shift="shift = true"
                        x-on:keyup.shift="shift = false"
                        x-on:keydown.enter="
                            if (! shift && ! $event.target.value) {
                                $event.preventDefault()
                            }

                            if (! shift && $event.target.value) {
                                $event.preventDefault()
                                $wire.sendMessage()
                            }
                        "
                    >
                        <x-fieldset.field name="content" id="contentMobile">
                            <x-input.textarea
                                rows="3"
                                class="max-h-40 min-h-20 [field-sizing:content]"
                                placeholder="Message {{ $discussion->is_direct_message ? $participant?->name : $discussion->name ?? 'group' }}"
                                wire:model.live="content"
                            ></x-input.textarea>

                            <div class="text-base/6 text-gray-500 dark:text-gray-400 sm:text-sm/6" data-slot="help">
                                Enter to send a message, Shift + Enter for a new line
                            </div>
                        </x-fieldset.field>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
