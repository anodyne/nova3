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
                    class="relative w-screen max-w-2xl"
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
                    >
                        <x-spacing size="md">
                            <header class="flex items-center justify-between">
                                <x-h2>Nova updates</x-h2>
                            </header>
                        </x-spacing>

                        <div class="relative mt-6 w-full flex-1 space-y-8 px-4 pb-8 leading-normal sm:px-6">
                            @if (cache()->missing('nova-update-available'))
                                <x-panel.primary icon="check" title="Nova is up-to-date">
                                    You are running the latest available release of Nova.
                                </x-panel.primary>
                            @endif

                            @if (cache()->has('nova-update-available'))
                                <x-panel well>
                                    <x-panel.well-heading>
                                        <x-slot name="heading">Nova {{ $upstream['version'] }} available</x-slot>

                                        @if ($upstream['severity'] === 'critical')
                                            <x-slot name="controls">
                                                <div
                                                    class="flex items-center gap-x-1 text-sm/6 font-medium text-danger-500"
                                                >
                                                    <x-icon name="update-alert" size="sm"></x-icon>
                                                    <p>Critical update</p>
                                                </div>
                                            </x-slot>
                                        @endif
                                    </x-panel.well-heading>

                                    <x-spacing size="2xs">
                                        <x-panel>
                                            <x-spacing size="md">
                                                <x-text size="lg" class="max-w-2xl">
                                                    {{ $upstream['notes'] }}
                                                </x-text>

                                                <div class="mt-8 flex items-center gap-2">
                                                    <x-button href="https://anodyne-productions.com" color="primary">
                                                        Get the update files &rarr;
                                                    </x-button>
                                                    <x-button plain>Learn more</x-button>
                                                </div>
                                            </x-spacing>
                                        </x-panel>
                                    </x-spacing>
                                </x-panel>
                            @endif

                            <div>
                                <x-h3>Version history</x-h3>

                                <ul role="list" class="mt-6 space-y-6">
                                    @foreach ($versionHistory as $version)
                                        <li class="relative flex gap-x-4">
                                            <div
                                                @class([
                                                    'absolute left-0 top-0 flex w-14 justify-center',
                                                    '-bottom-6' => ! $loop->last,
                                                ])
                                            >
                                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                                            </div>
                                            <div
                                                class="relative flex h-6 w-14 flex-none items-center justify-center bg-white dark:bg-gray-800"
                                            >
                                                @if (str($version->version)->endsWith('.0'))
                                                    <div
                                                        class="rounded-full bg-gray-950 px-2.5 text-xs/6 font-medium text-white dark:bg-white dark:text-gray-950"
                                                    >
                                                        v{{ $version->series }}
                                                    </div>
                                                @else
                                                    @if ($loop->first)
                                                        <div
                                                            class="rounded-full bg-gray-100 px-2.5 text-xs/6 font-medium text-gray-600 ring-1 ring-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:ring-gray-500"
                                                        >
                                                            v{{ $version->version }}
                                                        </div>
                                                    @else
                                                        <div
                                                            class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-700 dark:ring-gray-500"
                                                        ></div>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="flex-auto space-y-2 py-0.5">
                                                <x-text size="sm">{{ $version->description }}</x-text>

                                                <div class="flex gap-2">
                                                    @if (version_compare($version->version, $filesVersion, '=='))
                                                        <x-badge size="sm" color="primary">
                                                            Your installed version
                                                        </x-badge>
                                                    @endif

                                                    @foreach ($version->tags as $tag)
                                                        <x-badge size="sm">{{ str($tag)->ucfirst() }}</x-badge>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <time
                                                datetime="{{ $version->release_date }}"
                                                class="flex-none py-0.5 text-xs/5 text-gray-500"
                                            >
                                                {{ $version->release_date->shortRelativeToNowDiffForHumans() }}
                                            </time>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
