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

        <div class="mb-6 space-y-4">
            <flux:tabs class="w-full" wire:model.live="filter" variant="segmented">
                <flux:tab name="all">All</flux:tab>
                <flux:tab name="unread">Unread</flux:tab>
            </flux:tabs>

            <div
                class="group relative flex w-full items-center gap-x-2 rounded-lg bg-gray-950/[.02] px-3 py-2 ring-1 ring-inset ring-gray-950/5 dark:bg-white/[.04] dark:ring-white/5"
            >
                <div
                    class="shrink-0 text-gray-400 group-focus-within:text-gray-600 dark:text-gray-600 dark:group-focus-within:text-gray-400"
                >
                    <x-icon name="search" size="sm"></x-icon>
                </div>

                <input
                    type="text"
                    wire:model.live.debounce.500ms="search"
                    class="w-full appearance-none border-none bg-transparent p-0 text-sm/6 placeholder-gray-500 focus:outline-none focus:ring-0"
                    placeholder="Find messages..."
                />

                @if ($search)
                    <x-button tag="button" color="neutral" wire:click="$set('search', '')" text class="leading-none">
                        <x-icon name="x" size="sm"></x-icon>
                    </x-button>
                @endif
            </div>
        </div>

        <ul
            class="supports-[grid-template-columns:subgrid]:grid supports-[grid-template-columns:subgrid]:grid-cols-[auto_1fr_1.5rem_0.5rem_auto]"
            role="list"
        >
            @forelse ($discussions as $discussion)
                @php
                    $participant = $discussion->participants->first();
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
                        <div class="col-start-1 row-start-1 -ml-0.5 mr-3.5 mt-1 sm:mr-3">
                            <div class="size-2.5 rounded-full bg-primary-500"></div>
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
