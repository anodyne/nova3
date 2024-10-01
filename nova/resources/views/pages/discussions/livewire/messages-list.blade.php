<div class="flex h-[calc(100vh-theme(spacing.32))] flex-col lg:-m-10 lg:h-[calc(100vh-theme(spacing.4))] lg:p-10">
    <div class="flex h-full lg:gap-x-8 lg:overflow-auto">
        <aside
            @class([
                'h-full w-full lg:w-1/3 lg:overflow-auto',
                'max-md:hidden' => filled($selected),
            ])
        >
            <x-page-header :heading="$pageHeading" :description="$pageSubheading" :intro="$pageIntro">
                <x-slot name="actions">
                    <x-dropdown placement="bottom-end">
                        <x-slot name="emptyTrigger">
                            <x-button>
                                <x-icon name="write" size="sm"></x-icon>
                            </x-button>
                        </x-slot>

                        <x-dropdown.group>
                            <x-dropdown.item
                                type="button"
                                icon="user"
                                wire:click="$dispatch('openModal', { component: 'discussions-compose-direct-message-modal' })"
                            >
                                New direct message
                            </x-dropdown.item>
                            <x-dropdown.item
                                type="button"
                                icon="users-group"
                                wire:click="$dispatch('openModal', { component: 'discussions-compose-group-message-modal' })"
                            >
                                New group message
                            </x-dropdown.item>
                        </x-dropdown.group>
                    </x-dropdown>
                </x-slot>
            </x-page-header>

            <div
                class="mb-8 flex items-center gap-x-1.5 overflow-x-scroll rounded-full bg-gray-950/[.08] px-[5px] py-1 text-sm/6 dark:bg-white/5"
                data-slot="tabs"
            >
                <button
                    type="button"
                    wire:click="changeFilter('all')"
                    @class([
                        'flex flex-1 shrink-0 items-center justify-center gap-x-2 rounded-full px-3.5 py-1',
                        'bg-white font-semibold text-gray-950 shadow-sm ring-1 ring-gray-950/5 [--tab-icon:theme(colors.gray.500)] dark:bg-white/15 dark:text-white dark:shadow-none dark:[--tab-icon:theme(colors.gray.400)]' => $filter === 'all',
                        'font-medium text-gray-600 [--tab-icon:theme(colors.gray.500)] hover:bg-gray-900/10 hover:text-gray-950 dark:text-gray-400 dark:[--tab-icon:theme(colors.gray.400)] dark:hover:bg-white/[.08] dark:hover:text-white' => $filter !== 'all',
                    ])
                >
                    All
                </button>
                <button
                    type="button"
                    wire:click="changeFilter('private')"
                    @class([
                        'flex flex-1 shrink-0 items-center justify-center gap-x-2 rounded-full px-3.5 py-1',
                        'bg-white font-semibold text-gray-950 shadow-sm ring-1 ring-gray-950/5 [--tab-icon:theme(colors.gray.500)] dark:bg-white/15 dark:text-white dark:shadow-none dark:[--tab-icon:theme(colors.gray.400)]' => $filter === 'private',
                        'font-medium text-gray-600 [--tab-icon:theme(colors.gray.500)] hover:bg-gray-900/10 hover:text-gray-950 dark:text-gray-400 dark:[--tab-icon:theme(colors.gray.400)] dark:hover:bg-white/[.08] dark:hover:text-white' => $filter !== 'private',
                    ])
                >
                    Private
                </button>
                <button
                    type="button"
                    wire:click="changeFilter('group')"
                    @class([
                        'flex flex-1 shrink-0 items-center justify-center gap-x-2 rounded-full px-3.5 py-1',
                        'bg-white font-semibold text-gray-950 shadow-sm ring-1 ring-gray-950/5 [--tab-icon:theme(colors.gray.500)] dark:bg-white/15 dark:text-white dark:shadow-none dark:[--tab-icon:theme(colors.gray.400)]' => $filter === 'group',
                        'font-medium text-gray-600 [--tab-icon:theme(colors.gray.500)] hover:bg-gray-900/10 hover:text-gray-950 dark:text-gray-400 dark:[--tab-icon:theme(colors.gray.400)] dark:hover:bg-white/[.08] dark:hover:text-white' => $filter !== 'group',
                    ])
                >
                    Group
                </button>
            </div>

            <ul role="list">
                @forelse ($discussions as $discussion)
                    @php($participant = $discussion->participants->first())

                    <li
                        @class([
                            'cursor-pointer rounded-xl px-2.5 py-4',
                            'bg-primary-100 ring-1 ring-inset ring-primary-950/10 dark:bg-primary-950 dark:ring-white/10' => $selected === $discussion->id,
                        ])
                        wire:click="selectDiscussion({{ $discussion->id }})"
                    >
                        <div class="flex items-center gap-x-4">
                            <div>
                                @if (! $discussion->is_direct_message)
                                    <x-icon name="users-group" size="size-10"></x-icon>
                                @else
                                    @if (filled($participant))
                                        <x-avatar
                                            :src="$participant->avatar_url"
                                            :tooltip="$participant->name"
                                            size="sm"
                                        ></x-avatar>
                                    @else
                                        <x-icon name="user" size="xl"></x-icon>
                                    @endif
                                @endif
                            </div>

                            <div class="flex w-full min-w-0 flex-col">
                                <div class="grid grid-cols-3">
                                    <div class="col-span-2">
                                        @if (filled($discussion->name))
                                            <x-h4>{{ $discussion->name }}</x-h4>
                                        @else
                                            @if (filled($participant))
                                                <div class="flex items-center gap-x-4">
                                                    <x-h4>{{ $participant?->name }}</x-h4>

                                                    @if ($participant->trashed())
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
                                                <x-text size="lg">New message</x-text>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <div class="text-xs/5 text-gray-500">
                                            {{ format_date($discussion->updated_at) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3">
                                    <div class="col-span-2">
                                        @if (filled($discussion->lastMessage))
                                            <p class="mt-1 truncate text-xs/5 text-gray-500">
                                                {{ str($discussion->lastMessage->content)->limit(50, preserveWords: true) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-end">
                                        @if ($discussion->has_unread_messages)
                                            <div class="size-2.5 rounded-full bg-primary-500"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li>
                        <x-empty-state>
                            <x-icon name="messages"></x-icon>
                            <x-h3>No messages</x-h3>
                            <x-text>Get started by creating a new conversation</x-text>
                        </x-empty-state>
                    </li>
                @endforelse
            </ul>
        </aside>

        <livewire:discussions-message-history :discussion-id="$selected" />
    </div>
</div>

@pushOnce('scripts')
<script
    src="https://cdn.jsdelivr.net/npm/@marcreichel/alpine-auto-animate@latest/dist/alpine-auto-animate.min.js"
    defer
></script>
@endPushOnce
