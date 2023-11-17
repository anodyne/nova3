<div x-data="{ open: false }" class="leading-none">
    <button
        x-on:click.prevent="open = true"
        type="button"
        aria-label="Notifications"
        class="relative flex w-full appearance-none items-center gap-4 text-sm font-medium transition hover:text-gray-700 dark:hover:text-gray-300"
    >
        <div class="flex items-center gap-2.5">
            {{-- format-ignore-start --}}
            <svg class="icon tabler-icon h-7 w-7 md:h-6 md:w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 6h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                <path
                    d="M17 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"
                    @class([
                        'stroke-primary-500' => $unreadNotificationsCount > 0
                    ])
                ></path>
            </svg>
            {{-- format-ignore-end --}}
            <span class="font-medium">Notifications</span>
        </div>

        @if ($unreadNotificationsCount > 0)
            <span>
                <x-badge color="primary">
                    {{ $unreadNotificationsCount }}
                </x-badge>
            </span>
        @endif
    </button>

    <div
        x-on:sidebar-open.window="open = true"
        x-on:sidebar-close.window="open = false"
        x-on:keydown.window.escape="open = false"
        x-show="open"
        class="fixed inset-0 z-20 overflow-hidden"
        x-cloak
    >
        <div x-show="open" class="absolute inset-0 overflow-hidden">
            <div
                x-show="open"
                x-description="Background overlay, show/hide based on slide-over state."
                x-transition:enter="duration-500 ease-in-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="duration-500 ease-in-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/25 backdrop-blur transition-opacity"
                aria-hidden="true"
            ></div>

            <section
                x-on:click.away="open = false"
                class="absolute inset-y-4 right-4 flex max-w-full pl-10"
                aria-labelledby="slide-over-heading"
            >
                <div
                    class="relative w-screen max-w-md"
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    x-show="open"
                    x-transition:enter="transition duration-500 ease-in-out"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition duration-500 ease-in-out"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                >
                    <div
                        x-description="Close button, show/hide based on slide-over state."
                        x-show="open"
                        x-transition:enter="duration-500 ease-in-out"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="duration-500 ease-in-out"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4"
                    >
                        <button
                            x-on:click="open = false"
                            class="rounded-md text-gray-500 transition duration-200 ease-in-out hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                        >
                            <span class="sr-only">Close panel</span>
                            <x-icon name="x" size="md"></x-icon>
                        </button>
                    </div>

                    <div
                        class="flex h-full flex-col overflow-y-scroll rounded-lg bg-white py-6 shadow-xl ring-1 ring-gray-950/5 dark:bg-gray-800"
                    >
                        <header class="flex items-center justify-between px-4 sm:px-6">
                            <x-h2>Notifications</x-h2>

                            @if ($unreadNotificationsCount > 0)
                                <x-button.text
                                    tag="button"
                                    color="gray"
                                    wire:click="markAllNotificationsAsRead"
                                    leading="check"
                                >
                                    Mark all as read
                                </x-button.text>
                            @endif

                            @if ($unreadNotificationsCount === 0 && $hasNotifications)
                                <x-button.text
                                    tag="button"
                                    color="gray"
                                    wire:click="clearAllNotifications"
                                    leading="check"
                                >
                                    Clear all
                                </x-button.text>
                            @endif
                        </header>

                        <div class="relative mt-6 w-full flex-1 space-y-8 px-4 leading-normal sm:px-6">
                            @forelse ($notifications as $notification)
                                @include("pages.users.notifications.{$notification['type']}", compact('notification'))
                            @empty
                                <x-panel.primary icon="check" title="You're all caught up">
                                    You don't have any unread notifications.
                                </x-panel.primary>
                            @endforelse
                        </div>

                        <footer class="text-center">
                            <x-button.text color="neutral" leading="bell">Manage your notifications</x-button.text>
                        </footer>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
