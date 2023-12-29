@extends($meta->template)

@use('Composer\InstalledVersions')

@section('content')
    @php
        $filesVersion = app()->novaVersion();
        $databaseVersion = '3.0.1';
        $serverVersion = '3.0.2';
    @endphp

    <x-page-header>System Overview</x-page-header>

    <div class="space-y-8">
        <div class="grid gap-8 lg:grid-cols-2">
            <x-panel well>
                <x-content-box height="xs" width="sm">
                    <div class="flex items-center justify-between">
                        <x-fieldset.legend>Nova version</x-fieldset.legend>

                        <div>
                            @if (version_compare($filesVersion, $serverVersion, '>='))
                                <x-badge color="success">Up-to-date</x-badge>
                            @else
                                <x-badge color="danger">New version available</x-badge>
                            @endif
                        </div>
                    </div>
                </x-content-box>

                <x-content-box height="2xs" width="2xs">
                    <x-panel>
                        <x-content-box>
                            <div class="flex flex-col gap-6">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $filesVersion }}
                                </h2>
                            </div>
                        </x-content-box>
                    </x-panel>
                </x-content-box>
            </x-panel>

            <x-panel well>
                <x-content-box height="xs" width="sm">
                    <div class="flex items-center justify-between">
                        <x-fieldset.legend>Database version</x-fieldset.legend>

                        <div>
                            @if (version_compare($databaseVersion, $serverVersion, '>='))
                                <x-badge color="success">Up-to-date</x-badge>
                            @else
                                <x-badge color="danger">New version available</x-badge>
                            @endif
                        </div>
                    </div>
                </x-content-box>

                <x-content-box height="2xs" width="2xs">
                    <x-panel>
                        <x-content-box>
                            <div class="flex items-center gap-6">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $databaseVersion }}
                                </h2>
                            </div>
                        </x-content-box>
                    </x-panel>
                </x-content-box>
            </x-panel>
        </div>

        <div class="space-y-6">
            <div class="w-full max-w-2xl">
                <x-h2>Diagnostics</x-h2>
                <x-text class="mt-2">
                    The following information shows various version, environment, and driver information about your
                    system that may be useful.
                </x-text>
                <x-text class="mt-4">
                    If you're having issues with Nova, you can use the button below to copy the diagnostic information
                    and paste it into a Discord thread in the support channel. This will potentially help the support
                    staff immensely with resolving any issue.
                </x-text>
                <div class="mt-6 flex items-center gap-x-4">
                    <livewire:copy-diagnostic-data-button />
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <x-panel well>
                    <x-content-box height="xs" width="sm">
                        <div class="flex items-center justify-between">
                            <x-fieldset.legend>Environment</x-fieldset.legend>
                        </div>
                    </x-content-box>

                    <x-content-box height="2xs" width="2xs">
                        <x-panel>
                            <x-content-box>
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 lg:col-span-2 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-world" size="lg"></x-icon>
                                        <x-fieldset.label>URL</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ str(config('app.url'))->replace(['http://', 'https://'], '') }}
                                        </p>
                                    </div>

                                    <a
                                        href="{{ route('settings.general.edit') }}"
                                        @class([
                                            'group relative flex flex-col gap-y-2 rounded-md p-3',
                                            'bg-gray-950/[.04] ring-1 ring-inset ring-transparent transition',
                                            'hover:bg-gradient-to-b hover:from-white hover:to-primary-50 hover:text-primary-600 hover:shadow-md hover:shadow-primary-600/10 hover:ring-primary-600/20',
                                            'dark:bg-white/[.04]',
                                        ])
                                    >
                                        <div
                                            class="absolute right-3 top-3 text-gray-400 group-hover:text-primary-400 dark:text-gray-600 dark:group-hover:text-primary-600"
                                        >
                                            <x-icon name="settings" size="xs"></x-icon>
                                        </div>
                                        <x-icon name="tabler-code" size="lg"></x-icon>
                                        <x-fieldset.label>Debug mode</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('app.debug') ? 'Enabled' : 'Off' }}
                                        </p>
                                    </a>
                                    <a
                                        href="{{ route('settings.general.edit') }}"
                                        @class([
                                            'group relative flex flex-col gap-y-2 rounded-md p-3',
                                            'bg-gray-950/[.04] ring-1 ring-inset ring-transparent transition',
                                            'hover:bg-gradient-to-b hover:from-white hover:to-primary-50 hover:text-primary-600 hover:shadow-md hover:shadow-primary-600/10 hover:ring-primary-600/20',
                                            'dark:bg-white/[.04]',
                                        ])
                                    >
                                        <div
                                            class="absolute right-3 top-3 text-gray-400 group-hover:text-primary-400 dark:text-gray-600 dark:group-hover:text-primary-600"
                                        >
                                            <x-icon name="settings" size="xs"></x-icon>
                                        </div>
                                        <x-icon name="tabler-leaf" size="lg"></x-icon>
                                        <x-fieldset.label>Environment</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('app.env') }}
                                        </p>
                                    </a>

                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-brand-php" size="lg"></x-icon>
                                        <x-fieldset.label>PHP version</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ PHP_VERSION }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-brand-laravel" size="lg"></x-icon>
                                        <x-fieldset.label>Laravel version</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ app()->version() }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-bolt" size="lg"></x-icon>
                                        <x-fieldset.label>Livewire version</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ app()->livewireVersion() }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-table" size="lg"></x-icon>
                                        <x-fieldset.label>Filament version</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ app()->filamentVersion() }}
                                        </p>
                                    </div>
                                </div>
                            </x-content-box>
                        </x-panel>
                    </x-content-box>
                </x-panel>

                <x-panel well>
                    <x-content-box height="xs" width="sm">
                        <div class="flex items-center justify-between">
                            <x-fieldset.legend>Drivers</x-fieldset.legend>
                        </div>
                    </x-content-box>

                    <x-content-box height="2xs" width="2xs">
                        <x-panel>
                            <x-content-box>
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 lg:col-span-2 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-database" size="lg"></x-icon>
                                        <x-fieldset.label>Database</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ app('nova.environment')->database->driverName().' '.app('nova.environment')->database->version }}
                                        </p>
                                    </div>

                                    <a
                                        href="{{ route('settings.email.edit') }}"
                                        @class([
                                            'group relative flex flex-col gap-y-2 rounded-md p-3',
                                            'bg-gray-950/[.04] ring-1 ring-inset ring-transparent transition',
                                            'hover:bg-gradient-to-b hover:from-white hover:to-primary-50 hover:text-primary-600 hover:shadow-md hover:shadow-primary-600/10 hover:ring-primary-600/20',
                                            'dark:bg-white/[.04]',
                                        ])
                                    >
                                        <div
                                            class="absolute right-3 top-3 text-gray-400 group-hover:text-primary-400 dark:text-gray-600 dark:group-hover:text-primary-600"
                                        >
                                            <x-icon name="settings" size="xs"></x-icon>
                                        </div>
                                        <x-icon name="tabler-send" size="lg"></x-icon>
                                        <x-fieldset.label>Email</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('mail.default') }}
                                        </p>
                                    </a>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-bug" size="lg"></x-icon>
                                        <x-fieldset.label>Logging</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('logging.default') }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-rocket" size="lg"></x-icon>
                                        <x-fieldset.label>Cache</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('cache.default') }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-box" size="lg"></x-icon>
                                        <x-fieldset.label>Session</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('session.driver') }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-list-details" size="lg"></x-icon>
                                        <x-fieldset.label>Queue</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('queue.default') }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]"
                                    >
                                        <x-icon name="tabler-speakerphone" size="lg"></x-icon>
                                        <x-fieldset.label>Broadcasting</x-fieldset.label>
                                        <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ config('broadcasting.default') }}
                                        </p>
                                    </div>
                                </div>
                            </x-content-box>
                        </x-panel>
                    </x-content-box>
                </x-panel>
            </div>
        </div>
    </div>
@endsection
