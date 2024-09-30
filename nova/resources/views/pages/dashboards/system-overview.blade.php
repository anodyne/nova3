@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot name="actions">
            <livewire:nova-update-panel />
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
                If you’re having issues with Nova, you can use the button below to copy the diagnostic information and
                paste it into a Discord thread in the support channel. This can potentially help the support staff with
                resolving issues you may be having.
            </x-text>
            <div class="mt-6 flex items-center gap-x-4">
                <livewire:copy-diagnostic-data-button />
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <x-panel well>
                <x-panel.well.header
                    title="Environment"
                    description="Get an overview of the environment Nova is running in."
                ></x-panel.well.header>

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
                                href="{{ route('admin.settings.environment.edit') }}"
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
                                href="{{ route('admin.settings.environment.edit') }}"
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
            </x-panel>

            <x-panel well>
                <x-panel.well.header
                    title="Drivers"
                    description="Get an overview of the drivers for different systems that Nova uses."
                ></x-panel.well.header>

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
                                href="{{ route('admin.settings.email.edit') }}"
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
            </x-panel>
        </div>
    </div>
@endsection
