@use('Nova\Foundation\Enums\ReleaseSeverity')

<x-modal.slide-over title="Nova updates" icon="update">
    <div class="space-y-8">
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

                    @if ($hasCriticalUpdate)
                        <x-slot name="actions">
                            <div class="flex items-center gap-x-1 text-sm/6 font-medium text-danger-500">
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
                                <x-button :href="route('setup.start')" color="primary">Run the update &rarr;</x-button>
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
                            ({{ $upcoming->version }}) is currently planned, but no release date is available. This
                            message will be updated with more details as they become available.
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
</x-modal.slide-over>
