<div x-data="{ open: $wire.entangle('sidebarOpen') }" class="leading-none">
    <button type="button" x-on:click="open = true">
        @if (version_compare($filesVersion, $upstream['version'], '=='))
            @if (version_compare($filesVersion, $databaseVersion, '!='))
                <x-badge size="lg" color="info" pill>
                    <x-badge size="lg" color="info" pill>Nova {{ $filesVersion }}</x-badge>
                    Your database needs to be updated from {{ $databaseVersion }}
                </x-badge>
            @else
                <x-badge size="lg" color="success" pill>
                    <x-badge size="lg" color="success" pill>Nova {{ $filesVersion }}</x-badge>
                    Your site is up-to-date
                </x-badge>
            @endif
        @else
            @if ($upstream['severity'] === 'critical')
                <x-badge size="lg" color="danger" pill>
                    <x-badge size="lg" color="danger" pill>Nova {{ $upstream['version'] }} is available</x-badge>
                    Update from {{ $filesVersion }}
                </x-badge>
            @else
                <x-badge size="lg" color="warning" pill>
                    <x-badge size="lg" color="warning" pill>Nova {{ $upstream['version'] }} is available</x-badge>
                    Update from {{ $filesVersion }}
                </x-badge>
            @endif
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
                            </header>
                        </x-spacing>

                        <div class="relative mt-6 w-full flex-1 space-y-8 px-4 leading-normal sm:px-6">
                            @if (cache()->missing('nova-update-available'))
                                <x-panel.primary icon="check" title="Nova is up-to-date">
                                    There are no Nova updates that match your update notification criteria.
                                </x-panel.primary>
                            @endif

                            <x-panel.primary icon="check" title="Nova is up-to-date">
                                You are running the latest available release of Nova.
                            </x-panel.primary>

                            <x-panel.info icon="update" title="Nova 3.0.11 is available">
                                This is a {{ $upstream['severity'] }} release. Your current update notification
                                preferences don't include this type of update.
                            </x-panel.info>

                            <x-panel.warning icon="update" title="Nova 3.0.11 is available">
                                <div class="space-y-6">
                                    <p>{{ $upstream['notes'] }}</p>

                                    <p>This is a {{ $upstream['severity'] }} release.</p>
                                </div>
                            </x-panel.warning>

                            <x-panel.warning icon="update" title="Nova 3.0.11 is available">
                                <div class="space-y-6">
                                    <p>{{ $upstream['notes'] }}</p>

                                    <p>This is a {{ $upstream['severity'] }} release.</p>
                                </div>
                            </x-panel.warning>

                            <x-panel.danger icon="warning" title="Nova 3.0.11 is available">
                                <div class="space-y-6">
                                    <p>{{ $upstream['notes'] }}</p>

                                    <p>This is a {{ $upstream['severity'] }} release.</p>
                                </div>
                            </x-panel.danger>
                        </div>

                        <footer class="text-center">
                            <x-button :href="route('account.edit', 'notifications')" color="neutral" class="mb-6" text>
                                <x-icon name="bell" size="sm"></x-icon>
                                Manage your notifications
                            </x-button>
                        </footer>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
