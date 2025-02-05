@use('Nova\Foundation\Enums\ReleaseSeverity')

<div x-data="{ open: $wire.entangle('sidebarOpen') }" class="leading-none">
    <button type="button" x-on:click="open = true">
        @if (! $needsFilesUpdate)
            @if ($needsDatabaseUpdate)
                <x-badge size="lg" color="info" pill>
                    <x-badge size="lg" color="info" pill>Nova {{ $filesVersion }}</x-badge>
                    Your database needs to be updated from {{ $databaseVersion }}

                    @if ($hasUpcomingUpdate)
                        <x-icon.micro.calendar class="size-4"></x-icon.micro.calendar>
                    @endif
                </x-badge>
            @else
                <x-badge size="lg" color="success" pill>
                    <x-badge size="lg" color="success" pill>Nova {{ $filesVersion }}</x-badge>
                    Your site is up-to-date

                    @if ($hasUpcomingUpdate)
                        <x-icon.micro.calendar class="size-4"></x-icon.micro.calendar>
                    @endif
                </x-badge>
            @endif
        @else
            @if ($upstream->severity === ReleaseSeverity::Critical)
                <x-badge size="lg" color="danger" pill>
                    <x-badge size="lg" color="danger" pill>Nova {{ $upstream->version }} is available</x-badge>
                    Update from {{ $filesVersion }}

                    @if ($hasUpcomingUpdate)
                        <x-icon.micro.calendar class="size-4"></x-icon.micro.calendar>
                    @endif
                </x-badge>
            @else
                <x-badge size="lg" color="warning" pill>
                    <x-badge size="lg" color="warning" pill>Nova {{ $upstream->version }} is available</x-badge>
                    Update from {{ $filesVersion }}

                    @if ($hasUpcomingUpdate)
                        <x-icon.micro.calendar class="size-4"></x-icon.micro.calendar>
                    @endif
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
                            @if (! $hasUpdate)
                                <x-panel variant="well" color="primary">
                                    <x-panel.header
                                        title="Nova is up-to-date"
                                        icon="check"
                                        description="You are running the latest available release of Nova."
                                    ></x-panel.header>
                                </x-panel>
                            @endif

                            @if ($hasUpdate)
                                <x-panel variant="well">
                                    <x-panel.header>
                                        <x-slot name="title">Nova {{ $upstream->version }} is available</x-slot>

                                        @if ($upstream->severity === ReleaseSeverity::Critical)
                                            <x-slot name="actions">
                                                <div
                                                    class="flex items-center gap-x-1 text-sm/6 font-medium text-danger-500"
                                                >
                                                    <x-icon name="update-alert" size="sm"></x-icon>
                                                    <p>Critical update</p>
                                                </div>
                                            </x-slot>
                                        @endif
                                    </x-panel.header>

                                    <x-panel>
                                        <x-spacing size="md">
                                            @if (filled($upstream->notes))
                                                <x-text size="lg" class="max-w-2xl">
                                                    {{ $upstream->notes }}
                                                </x-text>
                                            @endif

                                            @if (filled($upstream->details))
                                                <div class="prose mt-4 dark:prose-invert">
                                                    {!! str($upstream->details)->markdown() !!}
                                                </div>
                                            @endif

                                            <div class="mt-8 flex items-center gap-2">
                                                @if ($needsFilesUpdate)
                                                    <x-button :href="$upstream->downloadLink" color="primary">
                                                        Get the update files &rarr;
                                                    </x-button>
                                                @endif

                                                @if ($needsDatabaseUpdate)
                                                    <x-button :href="route('setup.start')" color="primary">
                                                        Run the update &rarr;
                                                    </x-button>
                                                @endif

                                                {{-- <x-button plain>Learn more</x-button> --}}
                                            </div>
                                        </x-spacing>
                                    </x-panel>
                                </x-panel>
                            @endif

                            @if ($hasUpcomingUpdate)
                                <x-panel variant="well" color="info">
                                    <x-panel.header icon="calendar">
                                        @if (is_null($upcoming->date))
                                            <x-slot name="title">Upcoming Nova update planned</x-slot>

                                            <x-slot name="description">
                                                A {{ str($upcoming->severity->getLabel())->lower() }} release for Nova
                                                ({{ $upcoming->version }}) is currently planned, but no release date is
                                                available. This message will be updated with more details as they become
                                                available.
                                            </x-slot>
                                        @else
                                            <x-slot name="title">Upcoming Nova update scheduled</x-slot>

                                            <x-slot name="description">
                                                {{ str("Nova {$upcoming->version} is currently scheduled for release on **{$upcoming->date->format('F dS')}**.")->inlineMarkdown()->toHtmlString() }}
                                            </x-slot>
                                        @endif
                                    </x-panel.header>

                                    <x-panel color="info">
                                        <x-spacing size="row">
                                            <div class="prose prose-sm">
                                                {!! str("> {$upcoming->notes}")->markdown() !!}
                                            </div>
                                        </x-spacing>
                                    </x-panel>
                                </x-panel>
                            @endif

                            <div class="space-y-6">
                                <x-h3>Version history</x-h3>

                                <livewire:nova-version-history />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
