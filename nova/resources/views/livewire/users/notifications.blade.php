<div x-data="{ open: false }" class="leading-none">
    <x-link
        @click.prevent="open = true"
        {{-- wire:poll.30s="refreshNotifications" --}}
        tag="button"
        color="gray"
        class="relative p-1 rounded-full"
        aria-label="Notifications"
    >
        @icon('notification', 'h-6 w-6')

        @if ($this->hasUnreadNotifications)
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full text-white shadow-solid bg-danger-500"></span>
        @endif
    </x-link>

    <div
        @sidebar-open.window="open = true"
        @sidebar-close.window="open = false"
        @keydown.window.escape="open = false"
        x-show="open"
        class="fixed inset-0 overflow-hidden z-20"
        x-cloak
    >
        <div x-show="open" class="absolute inset-0 overflow-hidden">
            <div
                x-show="open"
                x-description="Background overlay, show/hide based on slide-over state."
                x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/25 transition-opacity backdrop-blur"
                aria-hidden="true"
            ></div>

            <section
                @click.away="open = false"
                class="absolute inset-y-4 right-4 pl-10 max-w-full flex"
                aria-labelledby="slide-over-heading"
            >
                <div
                    class="relative w-screen max-w-md"
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    x-show="open"
                    x-transition:enter="transition ease-in-out duration-500"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-500"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                >
                    <div
                        x-description="Close button, show/hide based on slide-over state."
                        x-show="open"
                        x-transition:enter="ease-in-out duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4"
                    >
                        <button
                            @click="open = false"
                            class="rounded-md text-gray-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-white transition ease-in-out duration-200"
                        >
                            <span class="sr-only">Close panel</span>
                            @icon('close', 'h-6 w-6')
                        </button>
                    </div>

                    <div class="h-full flex flex-col py-6 bg-white dark:bg-gray-800 ring-1 ring-gray-900/5 shadow-xl overflow-y-scroll rounded-xl">
                        <header class="flex items-center justify-between px-4 sm:px-6">
                            <x-h2>Notifications</x-h2>

                            @if ($this->hasUnreadNotifications)
                                <x-link tag="button" wire:click="markAllNotificationsAsRead" leading="check">
                                    Mark all as read
                                </x-link>
                            @endif

                            @if (! $this->hasUnreadNotifications && $this->hasNotifications)
                                <x-link tag="button" wire:click="clearAllNotifications" leading="check">
                                    Clear all
                                </x-link>
                            @endif
                        </header>

                        <div class="mt-6 relative w-full leading-normal px-4 space-y-8 sm:px-6">
                            @forelse ($notifications as $notification)
                                @include("livewire.users.notifications.{$notification['type']}", compact('notification'))
                            @empty
                                <x-panel.primary icon="check" title="You're all caught up">
                                    You don't have any unread notifications.
                                </x-panel.primary>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
