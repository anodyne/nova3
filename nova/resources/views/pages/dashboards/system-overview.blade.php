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
                    <x-spacing class="text-sm/6" size="md">
                        <div class="py-1.5">
                            <div class="flex w-full items-center justify-between gap-4">
                                <dt class="flex items-center gap-2 font-medium text-gray-500">URL</dt>
                                <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                    {{ str(config('app.url'))->replace('https://', '') }}
                                </dd>
                            </div>

                            @if (! str(config('app.url'))->startsWith('https'))
                                <div class="flex gap-x-1.5">
                                    <x-icon.micro.warning
                                        class="h-6 w-4 shrink-0 text-danger-500"
                                    ></x-icon.micro.warning>

                                    <p class="text-danger-500">
                                        Your site is missing an SSL certificate. If you have added an SSL certificate,
                                        please update your URL.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="py-1.5">
                            <div class="flex w-full items-center justify-between gap-4">
                                <dt class="flex items-center gap-2 font-medium text-gray-500">Environment</dt>
                                <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                    {{ config('app.env') }}
                                </dd>
                            </div>

                            @if (config('app.env') !== 'production')
                                <div class="flex gap-x-1.5">
                                    <x-icon.micro.warning
                                        class="h-6 w-4 shrink-0 text-danger-500"
                                    ></x-icon.micro.warning>

                                    <p class="text-danger-500">
                                        Your site’s environment is not set to production. For the optimal experience,
                                        please update your environment.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="py-1.5">
                            <div class="flex w-full items-center justify-between gap-4">
                                <dt class="flex items-center gap-2 font-medium text-gray-500">Debug mode</dt>
                                <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                    {{ config('app.debug') ? 'On' : 'Off' }}
                                </dd>
                            </div>

                            @if (config('app.debug') && config('app.env') === 'production')
                                <div class="flex gap-x-1.5">
                                    <x-icon.micro.warning
                                        class="h-6 w-4 shrink-0 text-danger-500"
                                    ></x-icon.micro.warning>

                                    <p class="text-danger-500">
                                        In a production environment, debug mode should always be off. If debug mode is
                                        on in production, you risk exposing sensitive configuration values to your end
                                        users.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Drivers" icon="server-settings"></x-panel.header>

                <x-panel>
                    <x-spacing class="text-sm/6" size="md">
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Email</dt>
                            <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                {{ config('mail.default') }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Logging</dt>
                            <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                {{ config('logging.default') }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Cache</dt>
                            <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                {{ config('cache.default') }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Session</dt>
                            <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                {{ config('session.driver') }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Queue</dt>
                            <dd class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white">
                                {{ config('queue.default') }}
                            </dd>
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Versions" icon="versions"></x-panel.header>

                <x-panel>
                    <x-spacing class="text-sm/6" size="md">
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">PHP</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ PHP_VERSION }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Database</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ app('nova.environment')->database->platform() }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Nova files</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ nova()->filesVersion() }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Nova database</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ nova()->databaseVersion() }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Laravel</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ app()->version() }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Livewire</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ app()->livewireVersion() }}
                            </dd>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 py-1.5">
                            <dt class="flex items-center gap-2 font-medium text-gray-500">Filament</dt>
                            <dd
                                class="flex min-w-0 items-center gap-1.5 text-right tabular-nums text-gray-950 dark:text-white"
                            >
                                {{ app()->filamentVersion() }}
                            </dd>
                        </div>
                    </x-spacing>
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
                <x-panel.header title="File permissions" icon="folder-settings"></x-panel.header>

                <x-panel>
                    <x-spacing class="text-sm/6" size="md">
                        @foreach ($folders as $path)
                            <div class="py-1.5">
                                <div class="flex w-full items-center justify-between gap-4">
                                    <dt class="flex items-center gap-2 font-medium text-gray-500">
                                        {{ str($path)->remove(base_path()) }}
                                    </dt>
                                    <dd
                                        class="flex min-w-0 items-center gap-1.5 text-right text-gray-950 dark:text-white"
                                    >
                                        @if (is_writable($path))
                                            <x-icon
                                                name="check-circle-filled"
                                                size="sm"
                                                class="text-success-500"
                                            ></x-icon>
                                        @else
                                            {{ substr(sprintf('%o', fileperms($path)), -4) }}
                                        @endif
                                    </dd>
                                </div>

                                @if (! is_writable($path))
                                    <div class="flex gap-x-1.5">
                                        <x-icon.micro.warning
                                            class="h-6 w-4 shrink-0 text-danger-500"
                                        ></x-icon.micro.warning>

                                        <p class="text-danger-500">
                                            Please adjust the folder permissions to be writable.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </x-spacing>
                </x-panel>
            </x-panel>
        </div>
    </div>
</x-admin-layout>
