@use('Nova\Settings\Enums\ServerEnvironment')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            <livewire:nova-update-panel-trigger />
        </x-slot>
    </x-page-heading>

    <div class="space-y-8">
        <div class="w-full max-w-2xl">
            <x-h2>Diagnostics</x-h2>
            <x-text class="mt-2">
                The following information shows various version, environment, and driver information about your system
                that may be useful.
            </x-text>
            <x-text class="mt-4">
                If you’re having issues with Nova, you can use the button below to copy diagnostic information to your
                clipboard so you can paste it into a Discord thread in the support channel. This can potentially help
                the support staff with resolving issues you may be having.
            </x-text>
            <div class="mt-6 flex items-center gap-x-4">
                <livewire:copy-diagnostic-data-button />
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-panel variant="well">
                <x-panel.header title="Environment" :icon="Tabler::Leaf">
                    <x-slot name="actions">
                        <x-button
                            x-on:click="Livewire.dispatch('slide-over.open', {component: 'settings-environment'})"
                            variant="subtle"
                            inset="right top bottom"
                            size="sm"
                        >
                            Edit
                        </x-button>
                    </x-slot>
                </x-panel.header>

                <x-panel>
                    <x-spacing.group height="sm">
                        <x-panel.group.row height="2xs">
                            <x-heading>URL</x-heading>
                            <x-text>{{ str(config('app.url'))->replace('https://', '') }}</x-text>

                            @if (! str(config('app.url'))->startsWith('https'))
                                <x-slot name="trailing">
                                    <div class="flex gap-1.5 text-sm/6">
                                        <x-icon.micro.warning
                                            class="text-danger-400 h-6 w-4 shrink-0"
                                        ></x-icon.micro.warning>

                                        <p class="text-danger-600 dark:text-danger-400">
                                            Your site is missing an SSL certificate. If you have added an SSL
                                            certificate, please update your URL.
                                        </p>
                                    </div>
                                </x-slot>
                            @endif
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Environment</x-heading>
                            <x-text>{{ config('app.env') }}</x-text>

                            @if (config('app.env') !== 'production')
                                <x-slot name="trailing">
                                    <div class="flex gap-1.5 text-sm/6">
                                        <x-icon.micro.warning
                                            class="text-danger-400 h-6 w-4 shrink-0"
                                        ></x-icon.micro.warning>

                                        <p class="text-danger-600 dark:text-danger-400">
                                            Your site’s environment is not set to production. For the optimal
                                            experience, please update your environment.
                                        </p>
                                    </div>
                                </x-slot>
                            @endif
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Debug mode</x-heading>
                            <x-text>{{ config('app.debug') ? 'On' : 'Off' }}</x-text>

                            @if (config('app.debug') && config('app.env') === 'production')
                                <div class="flex gap-1.5 text-sm/6">
                                    <x-icon.micro.warning
                                        class="text-danger-400 h-6 w-4 shrink-0"
                                    ></x-icon.micro.warning>

                                    <p class="text-danger-600 dark:text-danger-400">
                                        In a production environment, debug mode should always be off. If debug mode is
                                        on in production, you risk exposing sensitive configuration values to your end
                                        users.
                                    </p>
                                </div>
                            @endif
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Maintenance mode</x-heading>
                            <livewire:maintenance-mode-switch :maintenance="app()->isDownForMaintenance()" />

                            @if (app()->isDownForMaintenance())
                                <div class="flex gap-1.5 text-sm/6">
                                    <x-icon.micro.warning
                                        class="text-danger-400 h-6 w-4 shrink-0"
                                    ></x-icon.micro.warning>

                                    <p class="text-danger-600 dark:text-danger-400">
                                        Your application is currently down for maintenance.
                                    </p>
                                </div>
                            @endif
                        </x-panel.group.row>
                    </x-spacing.group>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Drivers" :icon="Tabler::ServerCog"></x-panel.header>

                <x-panel>
                    <x-spacing.group height="sm">
                        <x-panel.group.row height="2xs">
                            <x-heading>Email</x-heading>
                            <x-text>{{ config('mail.default') }}</x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Logging</x-heading>
                            <x-text>{{ config('logging.default') }}</x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Cache</x-heading>
                            <x-text>{{ config('cache.default') }}</x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Session</x-heading>
                            <x-text>{{ config('session.driver') }}</x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Queue</x-heading>
                            <x-text>{{ config('queue.default') }}</x-text>
                        </x-panel.group.row>
                    </x-spacing.group>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Versions" :icon="Tabler::Versions"></x-panel.header>

                <x-panel>
                    <x-spacing.group height="sm">
                        <x-panel.group.row height="2xs">
                            <x-heading>PHP</x-heading>
                            <x-text class="tabular-nums">{{ PHP_VERSION }}</x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Database</x-heading>
                            <x-text class="tabular-nums">
                                {{ app('nova.environment')->database->platform() }}
                            </x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Nova (files)</x-heading>
                            <x-text class="tabular-nums">
                                {{ nova()->filesVersion() }}
                            </x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Nova (database)</x-heading>
                            <x-text class="tabular-nums">
                                {{ nova()->databaseVersion() }}
                            </x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Laravel</x-heading>
                            <x-text class="tabular-nums">
                                {{ app()->version() }}
                            </x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Livewire</x-heading>
                            <x-text class="tabular-nums">
                                {{ app()->livewireVersion() }}
                            </x-text>
                        </x-panel.group.row>
                        <x-panel.group.row height="2xs">
                            <x-heading>Filament</x-heading>
                            <x-text class="tabular-nums">
                                {{ app()->filamentVersion() }}
                            </x-text>
                        </x-panel.group.row>
                    </x-spacing.group>
                </x-panel>
            </x-panel>

            @php
                $folders = [
                    storage_path(),
                    storage_path('logs'),
                    storage_path('framework'),
                    storage_path('framework/cache'),
                    storage_path('framework/sessions'),
                    storage_path('framework/views'),
                    nova_path('bootstrap/cache'),
                    public_path(),
                ];
            @endphp

            <x-panel variant="well">
                <x-panel.header title="File permissions" :icon="Tabler::FolderCog"></x-panel.header>

                <x-panel>
                    <x-spacing.group height="sm">
                        @foreach ($folders as $path)
                            <x-panel.group.row height="2xs">
                                <x-heading>
                                    {{ str($path)->remove(base_path()) }}
                                </x-heading>

                                @if (is_writable($path))
                                    <x-icon :name="Tabler::CircleCheckFilled" size="sm" class="text-success-500" />
                                @else
                                    {{ substr(sprintf('%o', fileperms($path)), -4) }}
                                @endif
                            </x-panel.group.row>
                        @endforeach
                    </x-spacing.group>
                </x-panel>
            </x-panel>
        </div>
    </div>
</x-admin-layout>
