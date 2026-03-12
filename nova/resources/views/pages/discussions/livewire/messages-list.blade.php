@use('Nova\Foundation\Helpers\DateHelper')

<div class="relative">
    <aside
        @class([
            'w-full shrink-0 lg:fixed lg:w-96',
            'max-md:hidden' => filled($selected),
        ])
    >
        <x-page-heading :heading="$pageHeading" :description="$pageSubheading" :intro="$pageIntro">
            <x-slot name="actions">
                <x-button
                    type="button"
                    variant="primary"
                    wire:click="$dispatch('modal.open', {component: 'discussions-compose-message-modal', arguments: {'mode': 'new'}})"
                >
                    <x-icon :name="Tabler::Edit" size="sm" />
                    <span class="block lg:hidden">New message</span>
                </x-button>
            </x-slot>
        </x-page-heading>

        <div class="mb-6 space-y-4">
            <x-radio.group class="w-full" wire:model.live="filter" variant="segmented">
                <x-radio value="all" label="All" />
                <x-radio value="unread" label="Unread" />
            </x-radio.group>

            <x-input wire:model.live.debounce="search" placeholder="Find messages..." variant="filled" clearable>
                <x-slot name="iconLeading">
                    <x-icon :name="Tabler::Search" size="sm" />
                </x-slot>
            </x-input>
        </div>

        <ul
            class="supports-[grid-template-columns:subgrid]:grid supports-[grid-template-columns:subgrid]:grid-cols-[auto_1fr_1.5rem_0.5rem_auto]"
            role="list"
        >
            @forelse ($discussions as $discussion)
                @php
                    $hasSeen = $discussion->notifications->first()?->is_seen ?? true;
                @endphp

                <li
                    @class([
                        'cursor-pointer rounded-lg px-2.5 py-3',
                        'col-span-full grid grid-cols-[auto_1fr_1.5rem_0.5rem_auto] items-baseline supports-[grid-template-columns:subgrid]:grid-cols-subgrid',
                        'bg-gray-100 dark:bg-gray-900' => $selected === $discussion->id,
                    ])
                    wire:click="selectDiscussion({{ $discussion->id }})"
                >
                    @if (! $hasSeen)
                        <div class="col-start-1 row-start-1 mt-1 mr-3.5 -ml-0.5 sm:mr-3">
                            <div class="bg-primary-500 size-2.5 rounded-full"></div>
                        </div>
                    @endif

                    <div class="col-start-2 row-start-1">
                        <div class="flex flex-col">
                            <div class="text-sm/6 font-semibold text-gray-950 dark:text-white">
                                @if (! $hasSeen)
                                    {{ $discussion->lastMessage->user->name }}
                                @else
                                    {{ $discussion->truncated_participants_string }}
                                @endif
                            </div>
                            <div class="text-sm/6 text-gray-500 dark:text-gray-400">
                                {{ $discussion->subject }}
                            </div>
                        </div>
                    </div>

                    <div class="col-start-5 row-start-1 flex justify-self-end">
                        <div class="text-xs/5 text-gray-500">
                            {{ DateHelper::formatDate($discussion->updated_at) }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="col-span-full">
                    <x-empty>
                        <x-illustration :name="Illustration::Inbox" />
                        <x-empty.heading>No messages</x-empty.heading>
                        <x-empty.text>Get started by creating a new conversation</x-empty.text>
                    </x-empty>
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
