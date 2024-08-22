<div x-data="{ open: false }" class="leading-none">
    <div class="hidden lg:block">
        <x-sidebar.item x-on:click.prevent="open = true" type="button" aria-label="Notifications">
            <x-icon name="bell" size="sm"></x-icon>
            <x-sidebar.label>Notifications</x-sidebar.label>

            @if ($unreadNotificationsCount > 0)
                <x-slot name="trailing">
                    <x-badge color="primary" class="tabular-nums">
                        {{ $unreadNotificationsCount }}
                    </x-badge>
                </x-slot>
            @endif
        </x-sidebar.item>
    </div>
    <div class="relative block lg:hidden">
        <x-navbar.item x-on:click.prevent="open = true" type="button" aria-label="Notifications">
            @if ($unreadNotificationsCount > 0)
                <div class="absolute right-1 top-2 size-2 rounded-full bg-danger-500"></div>
            @endif

            <x-icon name="bell"></x-icon>
        </x-navbar.item>
    </div>

    <template x-teleport="body">
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
                        class="relative w-screen max-w-lg"
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
                            class="absolute left-0 top-0 -ml-8 flex pr-2 pt-6 sm:-ml-10 sm:pr-4"
                        >
                            <button
                                type="button"
                                x-on:click="open = false"
                                class="rounded-md text-gray-500 transition duration-200 ease-in-out hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                            >
                                <span class="sr-only">Close panel</span>
                                <x-icon name="x" size="md"></x-icon>
                            </button>
                        </div>

                        <div
                            class="flex h-full flex-col overflow-y-scroll rounded-xl bg-white shadow-xl ring-1 ring-gray-950/5 dark:bg-gray-800"
                            x-data="tabsList('notifications')"
                        >
                            <x-spacing size="md">
                                <header class="flex items-center justify-between">
                                    <x-h2>Notifications</x-h2>

                                    @if ($unreadNotificationsCount > 0)
                                        <x-button
                                            tag="button"
                                            color="neutral"
                                            wire:click="markAllNotificationsAsRead"
                                            text
                                        >
                                            <x-icon name="check" size="md"></x-icon>
                                            Mark all as read
                                        </x-button>
                                    @endif

                                    @if ($unreadNotificationsCount === 0 && $hasNotifications)
                                        <x-button tag="button" color="neutral" wire:click="clearAllNotifications" text>
                                            <x-icon name="check" size="md"></x-icon>
                                            Clear all
                                        </x-button>
                                    @endif
                                </header>
                            </x-spacing>

                            <div class="relative mt-6 w-full flex-1 space-y-8 px-4 leading-normal sm:px-6">
                                @forelse ($notifications as $notification)
                                    <div class="flex justify-between gap-x-6">
                                        @include("notifications.{$notification['type']}", compact('notification'))

                                        <div class="shrink-0">
                                            <x-dropdown placement="bottom-end">
                                                <x-slot name="trigger">
                                                    <x-icon name="more"></x-icon>
                                                </x-slot>

                                                <x-dropdown.group>
                                                    <x-dropdown.item
                                                        wire:click="markNotificationAsRead({{ $notification['id'] }})"
                                                        icon="check"
                                                    >
                                                        Mark as read
                                                    </x-dropdown.item>
                                                    <x-dropdown.item-danger
                                                        wire:click="clearNotification({{ $notification['id'] }})"
                                                        icon="trash"
                                                    >
                                                        Clear notification
                                                    </x-dropdown.item-danger>
                                                </x-dropdown.group>
                                            </x-dropdown>
                                        </div>
                                    </div>
                                @empty
                                    <x-panel.primary icon="check" title="You're all caught up">
                                        You don’t have any unread notifications
                                    </x-panel.primary>
                                @endforelse
                            </div>

                            <footer class="text-center">
                                <x-button
                                    :href="route('admin.account.notifications')"
                                    color="neutral"
                                    class="mb-6"
                                    text
                                >
                                    <x-icon name="bell" size="sm"></x-icon>
                                    Manage your notifications
                                </x-button>
                            </footer>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </template>
</div>
