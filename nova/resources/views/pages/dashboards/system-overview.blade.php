@extends($meta->template)

@use('Composer\InstalledVersions')

@php
    $filesVersion = app()->novaVersion();
    $databaseVersion = '3.0.0';
    $serverVersion = '3.0.0';
@endphp

@section('content')
    <x-page-header>
        <x-slot name="heading">System overview</x-slot>

        <x-slot name="actions">
            @if (version_compare($filesVersion, $serverVersion, '=='))
                @if (version_compare($filesVersion, $databaseVersion, '!='))
                    <x-badge size="lg" color="warning" pill>
                        <x-badge size="lg" color="warning" pill>Nova {{ $filesVersion }}</x-badge>
                        Your database needs to be updated from Nova {{ $databaseVersion }}
                    </x-badge>
                @else
                    <x-badge size="lg" color="success" pill>
                        <x-badge size="lg" color="success" pill>Nova {{ $filesVersion }}</x-badge>
                        Your site is up-to-date
                    </x-badge>
                @endif
            @else
                <x-badge size="lg" color="danger" pill>
                    <x-badge size="lg" color="danger" pill>Nova {{ $serverVersion }} is available</x-badge>
                    Update your site from Nova {{ $filesVersion }}
                </x-badge>
            @endif
        </x-slot>
    </x-page-header>

    <div class="space-y-8">
        @if (version_compare($filesVersion, $serverVersion, '!='))
            <div class="w-full max-w-2xl">
                <x-panel well>
                    <x-panel.well-heading>
                        <x-slot name="heading">Nova {{ $serverVersion }}</x-slot>

                        <x-slot name="controls">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger" color="neutral">Ignore this update</x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to ignore this update? You won’t be prompted to update
                                        again until a new version is released.
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="tabler-bell-off">
                                        Ignore
                                    </x-dropdown.item-danger>
                                    <x-dropdown.item
                                        type="button"
                                        icon="prohibited"
                                        x-on:click.prevent="$dispatch('dropdown-close')"
                                    >
                                        Cancel
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            </x-dropdown>
                        </x-slot>
                    </x-panel.well-heading>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <x-text size="lg" class="max-w-2xl">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum quos corporis suscipit
                                    odio rerum illo porro officiis quod quis fugiat aliquid, esse, culpa, repellat dicta
                                    nemo minus ipsam iusto nihil?
                                </x-text>

                                <div class="mt-8 flex items-center gap-2">
                                    <x-button color="primary">Get the update files &rarr;</x-button>
                                    <x-button plain>Learn more</x-button>
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </div>
        @endif

        <div class="w-full max-w-2xl">
            <x-h2>Diagnostics</x-h2>
            <x-text class="mt-2">
                The following information shows various version, environment, and driver information about your system
                that may be useful.
            </x-text>
            <x-text class="mt-4">
                If you’re having issues with Nova, you can use the button below to copy the diagnostic information and
                paste it into a Discord thread in the support channel. This will potentially help the support staff
                immensely with resolving any issue.
            </x-text>
            <div class="mt-6 flex items-center gap-x-4">
                <livewire:copy-diagnostic-data-button />
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-panel well>
                <x-panel.well-heading heading="Environment"></x-panel.well-heading>

                <x-spacing size="2xs">
                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div
                                    class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04] lg:col-span-2"
                                >
                                    <div class="flex justify-between">
                                        <div class="flex flex-col gap-y-2">
                                            <x-icon name="tabler-world" size="lg"></x-icon>
                                            <x-fieldset.label>URL</x-fieldset.label>
                                        </div>
                                        @if (! str(config('app.url'))->startsWith('https'))
                                            <div
                                                class="relative text-danger-600 dark:text-danger-500"
                                                x-tooltip.raw="Your site is missing an SSL certificate. If you have added an SSL certificate, please update your ENV file."
                                            >
                                                <x-icon name="lock-open" size="sm"></x-icon>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ str(config('app.url'))->replace('https://', '') }}
                                    </p>
                                </div>

                                <a
                                    href="{{ route('settings.environment.edit') }}"
                                    @class([
                                        'group relative flex flex-col gap-y-2 rounded-md p-3',
                                        'bg-gray-950/[.04] ring-1 ring-inset ring-transparent transition',
                                        'hover:bg-gradient-to-b hover:from-white hover:to-primary-50 hover:text-primary-600 hover:shadow-md hover:shadow-primary-600/10 hover:ring-primary-600/20 dark:hover:from-gray-900 dark:hover:to-primary-950',
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
                                    href="{{ route('settings.environment.edit') }}"
                                    @class([
                                        'group relative flex flex-col gap-y-2 rounded-md p-3',
                                        'bg-gray-950/[.04] ring-1 ring-inset ring-transparent transition',
                                        'hover:bg-gradient-to-b hover:from-white hover:to-primary-50 hover:text-primary-600 hover:shadow-md hover:shadow-primary-600/10 hover:ring-primary-600/20 dark:hover:from-gray-900 dark:hover:to-primary-950',
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

                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-brand-php" size="lg"></x-icon>
                                    <x-fieldset.label>PHP version</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ PHP_VERSION }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-brand-laravel" size="lg"></x-icon>
                                    <x-fieldset.label>Laravel version</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ app()->version() }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-brand-livewire" size="lg"></x-icon>
                                    <x-fieldset.label>Livewire version</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ app()->livewireVersion() }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-table" size="lg"></x-icon>
                                    <x-fieldset.label>Filament version</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ app()->filamentVersion() }}
                                    </p>
                                </div>
                            </div>
                        </x-spacing>
                    </x-panel>
                </x-spacing>
            </x-panel>

            <x-panel well>
                <x-panel.well-heading heading="Drivers"></x-panel.well-heading>

                <x-spacing size="2xs">
                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div
                                    class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04] lg:col-span-2"
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
                                        'hover:bg-gradient-to-b hover:from-white hover:to-primary-50 hover:text-primary-600 hover:shadow-md hover:shadow-primary-600/10 hover:ring-primary-600/20 dark:hover:from-gray-900 dark:hover:to-primary-950',
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
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-bug" size="lg"></x-icon>
                                    <x-fieldset.label>Logging</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ config('logging.default') }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-rocket" size="lg"></x-icon>
                                    <x-fieldset.label>Cache</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ config('cache.default') }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-box" size="lg"></x-icon>
                                    <x-fieldset.label>Session</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ config('session.driver') }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-list-details" size="lg"></x-icon>
                                    <x-fieldset.label>Queue</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ config('queue.default') }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-y-2 rounded-md bg-gray-950/[.04] p-3 dark:bg-white/[.04]">
                                    <x-icon name="tabler-speakerphone" size="lg"></x-icon>
                                    <x-fieldset.label>Broadcasting</x-fieldset.label>
                                    <p class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ config('broadcasting.default') }}
                                    </p>
                                </div>
                            </div>
                        </x-spacing>
                    </x-panel>
                </x-spacing>
            </x-panel>
        </div>
    </div>
@endsection
