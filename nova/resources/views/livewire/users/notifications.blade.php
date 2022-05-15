<div x-data="{ open: false }" class="leading-none">
    <x-button
        @click.prevent="open = true"
        {{-- wire:poll.30s="refreshNotifications" --}}
        type="button"
        color="gray-text"
        size="none"
        class="relative p-1 rounded-full"
        aria-label="Notifications"
    >
        @icon('notification', 'h-6 w-6')

        @if ($this->hasUnreadNotifications())
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full text-white shadow-solid bg-red-500"></span>
        @endif
    </x-button>

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
                class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>

            <section
                @click.away="open = false"
                class="absolute inset-y-0 right-0 pl-10 max-w-full flex"
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

                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                        <header class="flex items-center justify-between px-4 sm:px-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Notifications
                            </h2>

                            @if ($this->hasUnreadNotifications())
                                <button wire:click="markAllNotificationsAsRead" type="button" class="inline-flex items-center text-xs text-gray-500 hover:text-gray-600 transition ease-in-out duration-200 focus:outline-none">
                                    @icon('check', 'h-5 w-5')
                                    <span class="ml-2">Mark all as read</span>
                                </button>
                            @endif

                            @if (! $this->hasUnreadNotifications() && $this->hasNotifications())
                                <button wire:click="clearAllNotifications" type="button" class="inline-flex items-center text-xs text-gray-500 hover:text-gray-600 transition ease-in-out duration-200 focus:outline-none">
                                    @icon('check', 'h-5 w-5')
                                    <span class="ml-2">Clear all</span>
                                </button>
                            @endif
                        </header>

                        <div class="mt-6 relative flex-1 leading-normal px-4 space-y-8 sm:px-6">
                            @forelse ($notifications as $notification)
                                <div class="flex items-center w-full">
                                    @include("livewire.users.notifications.{$notification['type']}", compact('notification'))
                                </div>
                            @empty
                                <div class="rounded-md bg-blue-50 p-4">
                                    <div class="flex items-center">
                                        <div class="shrink-0">
                                            @icon('check', 'h-6 w-6 text-blue-500')
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium text-blue-600">
                                                No unread notifications
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
