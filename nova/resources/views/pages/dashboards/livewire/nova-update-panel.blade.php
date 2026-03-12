@use('Nova\Foundation\Enums\ReleaseSeverity')

<x-modal.slide-over title="Nova updates" :color="$statusColor" :icon="Tabler::RefreshDot">
    <div class="space-y-8">
        @if (! $hasUpdate)
            <x-callout.success :icon="Tabler::CircleCheck" icon:size="md">
                You’re running the latest available release of Nova.
            </x-callout.success>
        @endif

        @if ($hasUpdate)
            <x-panel variant="well">
                <x-panel.header>
                    <x-slot name="title">Nova {{ $upstream->version }} is available</x-slot>

                    @if ($hasCriticalUpdate)
                        <x-slot name="actions">
                            <div class="text-danger-500 flex items-center gap-x-1 text-sm/6 font-medium">
                                <x-icon :name="Tabler::RefreshAlert" size="sm" />
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
                            <div class="prose dark:prose-invert mt-4">
                                {!! str($upstream->details)->markdown() !!}
                            </div>
                        @endif
                    </x-spacing>
                </x-panel>

                <x-panel.footer>
                    @if ($needsFilesUpdate)
                        <x-button :href="$upstream->downloadLink" variant="ghost" inset="left top bottom">
                            Get the update files
                            <span aria-hidden="true">→</span>
                        </x-button>
                    @endif

                    @if ($needsDatabaseUpdate)
                        <x-button :href="route('setup.start')" variant="ghost" inset="left top bottom">
                            Run the update
                            <span aria-hidden="true">→</span>
                        </x-button>
                    @endif
                </x-panel.footer>
            </x-panel>
        @endif

        @if ($hasUpcomingUpdate)
            <x-panel variant="well" color="info">
                <x-panel.header :icon="Tabler::Calendar">
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
                        <div class="prose prose-sm dark:prose-invert">
                            {!! str("> {$upcoming->notes}")->markdown() !!}
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>
        @endif

        <div class="space-y-6">
            <x-heading size="lg" level="3">Version history</x-heading>

            <livewire:nova-version-history />
        </div>
    </div>
</x-modal.slide-over>
