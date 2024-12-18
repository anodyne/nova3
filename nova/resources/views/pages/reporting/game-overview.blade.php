<x-admin-layout>
    <x-page-header heading="Game overview over the last 7 days"></x-page-header>

    <div class="space-y-8">
        <div class="grid gap-8 lg:grid-cols-2">
            <x-panel well>
                <x-panel.well.header
                    title="Participation"
                    description="This provides insight into player participation over the last 7 days."
                ></x-panel.well.header>

                <x-panel>
                    <x-spacing size="md" class="flex items-center justify-center gap-x-8">
                        <x-circular-progress :percentage="83" class="size-20"></x-circular-progress>
                        <div>
                            <h2
                                class="shrink-0 text-6xl font-extrabold tabular-nums tracking-tight text-gray-950 dark:text-white"
                            >
                                83%
                            </h2>
                            <div class="flex items-center gap-x-4">
                                <x-text>10 of 12 users</x-text>
                                <x-badge color="success">&uarr; 4%</x-badge>
                            </div>
                        </div>
                    </x-spacing>
                </x-panel>

                <x-panel.well.footer>
                    <x-button text>View the contribution report &rarr;</x-button>
                </x-panel.well.footer>
            </x-panel>

            <x-panel well>
                <x-panel.well.header
                    title="Activity"
                    description="This provides insight into player activity level over the last 7 days."
                ></x-panel.well.header>

                <x-panel>
                    <x-spacing size="md" class="flex items-center justify-center gap-x-8">
                        <x-circular-progress :percentage="42" color="warning" class="size-20"></x-circular-progress>
                        <div>
                            <h2
                                class="shrink-0 text-6xl font-extrabold tabular-nums tracking-tight text-gray-950 dark:text-white"
                            >
                                42%
                            </h2>
                            <div class="flex items-center gap-x-4">
                                <x-text>5 of 12 users</x-text>
                                <x-badge color="danger">&darr; 18%</x-badge>
                            </div>
                        </div>
                    </x-spacing>
                </x-panel>

                <x-panel.well.footer>
                    <x-button text>View the activity report &rarr;</x-button>
                </x-panel.well.footer>
            </x-panel>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-panel well>
                <x-panel.well.header
                    title="Posting"
                    description="This provides insight into the number of posts over the last 7 days."
                ></x-panel.well.header>

                <x-panel>
                    <x-spacing size="md">
                        <div class="grid grid-cols-1 lg:grid-cols-2">
                            <x-panel.stat label="Published posts" value="18"></x-panel.stat>
                            <x-panel.stat label="Draft posts" value="4"></x-panel.stat>
                        </div>
                    </x-spacing>
                </x-panel>

                <x-panel.well.footer>
                    <x-button text>Go to the writing dashboard &rarr;</x-button>
                </x-panel.well.footer>
            </x-panel>

            <x-panel well>
                <x-panel.well.header
                    title="Activity"
                    description="This provides insight into player activity level over the last 7 days."
                ></x-panel.well.header>

                <x-panel>
                    <x-spacing size="md">
                        <div class="grid grid-cols-1 lg:grid-cols-2">
                            <x-panel.stat label="Published posts" value="18"></x-panel.stat>
                            <x-panel.stat label="Draft posts" value="4"></x-panel.stat>
                        </div>
                    </x-spacing>
                </x-panel>

                <x-panel.well.footer>
                    <x-button text>View the activity report &rarr;</x-button>
                </x-panel.well.footer>
            </x-panel>
        </div>
    </div>
</x-admin-layout>
