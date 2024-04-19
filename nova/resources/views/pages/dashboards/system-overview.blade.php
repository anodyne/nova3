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

            <div class="mt-6 max-w-xs">
                <x-panel well>
                    <x-panel.well-heading heading="Background color"></x-panel.well-heading>

                    <x-spacing size="2xs">
                        <x-panel>
                            <livewire:advanced-color-picker />
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </div>

            <div
                class="mt-6 max-w-xs rounded-xl ring-1 ring-gray-950/10 shadow divide-y divide-gray-950/10"
                x-data="{
                    shade: 500,
                    color: 'sky',
                }"
            >
                <div class="px-4 py-4">
                    <x-fieldset.field>
                        <x-fieldset.label>Shade</x-fieldset.label>
                        <x-fieldset.description>Choose a color shade to customize the color picker.</x-fieldset.description>
                        <x-input.range x-model="shade"></x-input.range>
                    </x-fieldset.field>
                </div>
                <div class="p-4">
                    <x-fieldset.field>
                        <x-fieldset.label>
                            <div class="flex items-center justify-between">
                                <div>Color</div>
                                <div x-text="color" class="font-normal text-xs/5 text-gray-500"></div>
                            </div>
                        </x-fieldset.label>
                        <div data-slot="control" class="grid grid-cols-6 gap-x-3 gap-y-3 *:size-7 *:rounded-full *:border *:border-black/10">
                            <button
                                class="bg-red-500"
                                x-on:click="color = 'red'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'red' }"
                            ></button>
                            <button
                                class="bg-orange-500"
                                x-on:click="color = 'orange'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'orange' }"
                            ></button>
                            <button
                                class="bg-amber-500"
                                x-on:click="color = 'amber'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'amber' }"
                            ></button>
                            <button
                                class="bg-yellow-500"
                                x-on:click="color = 'yellow'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'yellow' }"
                            ></button>
                            <button
                                class="bg-lime-500"
                                x-on:click="color = 'lime'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'lime' }"
                            ></button>
                            <button
                                class="bg-green-500"
                                x-on:click="color = 'green'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'green' }"
                            ></button>

                            <button
                            x-on:click="color = 'emerald'"
                            x-bind:class="{
                                [`bg-emerald-${shade}`]: true,
                                'ring-2 ring-offset-2 ring-blue-500': color === 'emerald',
                            }"
                            ></button>
                            <button
                            x-on:click="color = 'teal'"
                            x-bind:class="{
                                [`bg-teal-${shade}`]: true,
                                'ring-2 ring-offset-2 ring-blue-500': color === 'teal',
                            }"
                            ></button>
                            <button
                            x-on:click="color = 'cyan'"
                            x-bind:class="{
                                [`bg-cyan-${shade}`]: true,
                                'ring-2 ring-offset-2 ring-blue-500': color === 'cyan',
                            }"
                            ></button>
                            <button
                                x-on:click="color = 'sky'"
                                x-bind:class="{
                                    [`bg-sky-${shade}`]: true,
                                    'ring-2 ring-offset-2 ring-blue-500': color === 'sky',
                                }"
                            ></button>
                            <button
                            x-on:click="color = 'blue'"
                            x-bind:class="{
                                [`bg-blue-${shade}`]: true,
                                'ring-2 ring-offset-2 ring-blue-500': color === 'blue',
                            }"
                            ></button>
                            <button
                            x-on:click="color = 'indigo'"
                            x-bind:class="{
                                [`bg-indigo-${shade}`]: true,
                                'ring-2 ring-offset-2 ring-blue-500': color === 'indigo',
                            }"
                            ></button>

                            <button
                                class="bg-violet-500"
                                x-on:click="color = 'violet'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'violet' }"
                            ></button>
                            <button
                                class="bg-purple-500"
                                x-on:click="color = 'purple'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'purple' }"
                            ></button>
                            <button
                                class="bg-fuchsia-500"
                                x-on:click="color = 'fuchsia'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'fuchsia' }"
                            ></button>
                            <button
                                class="bg-pink-500"
                                x-on:click="color = 'pink'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'pink' }"
                            ></button>
                            <button
                                class="bg-rose-500"
                                x-on:click="color = 'rose'"
                                x-bind:class="{ 'ring-2 ring-offset-2 ring-blue-500': color === 'rose' }"
                            ></button>
                        </div>
                    </x-fieldset.field>
                </div>
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
                                    href="{{ route('settings.general.edit') }}"
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