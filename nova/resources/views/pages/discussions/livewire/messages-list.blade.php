@use('Nova\Foundation\Helpers\DateHelper')

<div class="relative">
    <aside @class([
        'w-full shrink-0 lg:fixed lg:w-96',
        'max-md:hidden' => filled($selected),
    ])>
        <x-page-header :heading="$pageHeading" :description="$pageSubheading" :intro="$pageIntro">
            <x-slot name="actions">
                <x-button
                    type="button"
                    color="primary"
                    wire:click="$dispatch('openModal', { component: 'discussions-compose-message-modal', arguments: { mode: 'new' }})"
                >
                    <x-icon name="write" size="sm"></x-icon>
                    <span class="block lg:hidden">New message</span>
                </x-button>
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

        <ul
            class="supports-[grid-template-columns:subgrid]:grid supports-[grid-template-columns:subgrid]:grid-cols-[auto_1fr_1.5rem_0.5rem_auto]"
            role="list"
        >
            @forelse ($discussions as $discussion)
                @php($participant = $discussion->participants->first())

                <li
                    @class([
                        'cursor-pointer rounded-lg px-2.5 py-4',
                        'col-span-full grid grid-cols-[auto_1fr_1.5rem_0.5rem_auto] items-center supports-[grid-template-columns:subgrid]:grid-cols-subgrid',
                        'bg-gray-100 dark:bg-gray-900' => $selected === $discussion->id,
                    ])
                    wire:click="selectDiscussion({{ $discussion->id }})"
                >
                    @if ($discussion->has_unread_messages)
                        <div class="col-start-1 row-start-1 -ml-0.5 mr-3.5 sm:mr-3">
                            <div class="size-2.5 rounded-full bg-primary-500"></div>
                        </div>
                    @endif

                    <div class="col-start-2 row-start-1">
                        <div class="flex items-center gap-x-2.5">
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
                    </div>

                    <div class="col-start-5 row-start-1 flex justify-self-end">
                        <div class="text-xs/5 text-gray-500">
                            {{ DateHelper::formatDate($discussion->updated_at) }}
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

        <div class="mt-4">
            {{ $discussions->links() }}
        </div>
    </aside>

    <section class="lg:ml-[26rem] lg:flex-1">
        <livewire:discussions-message-history :discussion-id="$selected" />
    </section>
</div>

@pushOnce('scripts')
<script
    src="https://cdn.jsdelivr.net/npm/@marcreichel/alpine-auto-animate@latest/dist/alpine-auto-animate.min.js"
    defer
></script>
@endPushOnce
