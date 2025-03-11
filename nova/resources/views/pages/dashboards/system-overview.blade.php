@use('Nova\Settings\Enums\ServerEnvironment')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <livewire:nova-update-panel-trigger />
        </x-slot>
    </x-page-header>

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
                <x-panel.header title="Environment" icon="leaf">
                    <x-slot name="actions">
                        <x-button
                            x-on:click="Livewire.dispatch('slide-over.open', {component: 'settings-environment'})"
                            color="primary"
                            text
                        >
                            Edit
                        </x-button>
                    </x-slot>
                </x-panel.header>

                <x-panel>
                    <x-spacing size="md">
                        <div class="grid grid-cols-4 gap-8 px-3 py-1.5 text-sm/6">
                            <div class="col-span-3 font-medium">
                                <p>URL</p>

                                @if (! str(config('app.url'))->startsWith('https'))
                                    <div class="flex gap-x-1">
                                        <x-icon.micro.warning
                                            class="mt-1 shrink-0 text-danger-500"
                                        ></x-icon.micro.warning>

                                        <p class="text-danger-500">
                                            Your site is missing an SSL certificate. If you have added an SSL
                                            certificate, please update your URL.
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-end">
                                {{ str(config('app.url'))->replace('https://', '') }}
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-8 px-3 py-1.5 text-sm/6">
                            <div class="col-span-3 font-medium">
                                <p>Environment</p>

                                @if (config('app.env') !== 'production')
                                    <div class="flex gap-x-1">
                                        <x-icon.micro.warning
                                            class="mt-1 shrink-0 text-danger-500"
                                        ></x-icon.micro.warning>

                                        <p class="text-danger-500">
                                            Your site’s environment is not set to production. For the optimal
                                            experience, please update your environment.
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-end">
                                {{ config('app.env') }}
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-8 px-3 py-1.5 text-sm/6">
                            <div class="col-span-3 font-medium">
                                <p>Debug mode</p>

                                @if (config('app.debug') && config('app.env') === 'production')
                                    <div class="flex gap-x-1">
                                        <x-icon.micro.warning
                                            class="mt-1 shrink-0 text-danger-500"
                                        ></x-icon.micro.warning>

                                        <p class="text-danger-500">
                                            In a production environment, debug mode should always be off. If debug mode
                                            is on in production, you risk exposing sensitive configuration values to
                                            your end users.
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-end">
                                {{ config('app.debug') ? 'On' : 'Off' }}
                            </div>
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Drivers" icon="server-settings"></x-panel.header>

                <x-panel>
                    <x-spacing size="md">
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Email</div>
                            <div class="tabular-nums">{{ config('mail.default') }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Logging</div>
                            <div class="tabular-nums">{{ config('logging.default') }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Cache</div>
                            <div class="tabular-nums">{{ config('cache.default') }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Session</div>
                            <div class="tabular-nums">{{ config('session.driver') }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Queue</div>
                            <div class="tabular-nums">{{ config('queue.default') }}</div>
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Versions" icon="versions"></x-panel.header>

                <x-panel>
                    <x-spacing size="md">
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">PHP</div>
                            <div class="tabular-nums">{{ PHP_VERSION }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Database</div>
                            <div class="tabular-nums">{{ app('nova.environment')->database->platform() }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Laravel</div>
                            <div class="tabular-nums">{{ app()->version() }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Livewire</div>
                            <div class="tabular-nums">{{ app()->livewireVersion() }}</div>
                        </div>
                        <div class="flex items-center justify-between px-3 py-1.5 text-sm/6">
                            <div class="font-medium">Filament</div>
                            <div class="tabular-nums">{{ app()->filamentVersion() }}</div>
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>
        </div>
    </div>
</x-admin-layout>
