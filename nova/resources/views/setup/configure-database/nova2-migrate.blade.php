@php
    use Nova\Setup\Enums\DatabaseConfigStatus;
@endphp

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        @if ($status === DatabaseConfigStatus::alreadyConfigured)
            <p class="text-lg/8 text-gray-600">
                It looks like you’ve already configured your database connection. Next we’ll migrate your Nova 2 data to
                the new format.
            </p>
        @elseif ($status === DatabaseConfigStatus::failedToWriteEnv)
            <p class="text-lg/8 text-gray-600">
                We weren’t able to write your database credentials to the config file. Follow the instructions below to
                ensure Nova can connect to the database where Nova 2 is installed.
            </p>
        @elseif ($status === DatabaseConfigStatus::failedToVerify)
            <p class="text-lg/8 text-gray-600">
                We weren’t able to verify your database connection using the values we saved to the config file. Either
                the file was not saved correctly or your database is unavailable right now.
            </p>
        @else
            <p class="text-lg/8 text-gray-600">
                When migrating from Nova 2, you can pull your data from the same database where Nova 3 is installed or
                you can specify a different database where your Nova 2 data lives.
            </p>
        @endif
    </header>

    @if ($status === DatabaseConfigStatus::alreadyConfigured)
        <div class="flex items-center justify-center">
            <x-button.setup href="{{ url('setup/migrate') }}" leading="tabler-database-import">
                Continue migration
            </x-button.setup>
        </div>
    @endif

    @if ($shouldShowDatabaseOptions)
        <div class="mx-auto max-w-2xl space-y-8">
            <div class="grid grid-cols-2 gap-8">
                <x-button.filled color="neutral" wire:click="useSameDatabaseForMigration">
                    <x-content-box class="space-y-2 text-left">
                        <x-icon name="tabler-database" size="xl" class="text-gray-600"></x-icon>
                        <x-h3>Use the same database</x-h3>
                        <p class="text-sm/6 font-normal text-gray-600">
                            Your Nova 2 database tables live in the same database that you are installing Nova 3 into.
                        </p>
                    </x-content-box>
                </x-button.filled>

                <x-button.filled color="neutral" wire:click="useDifferentDatabaseForMigration">
                    <x-content-box class="space-y-2 text-left">
                        <x-icon name="tabler-database-export" size="xl" class="text-gray-600"></x-icon>
                        <x-h3>Use a different database</x-h3>
                        <p class="text-sm/6 font-normal text-gray-600">
                            Your Nova 2 database tables live in a separate database from the one you are installing Nova
                            3 into.
                        </p>
                    </x-content-box>
                </x-button.filled>
            </div>

            <div class="flex flex-col items-center">
                <x-button.filled :href="url('setup/migrate')" color="neutral">
                    Back to migration center
                </x-button.filled>
            </div>
        </div>
    @else
        @if ($shouldShowForm)
            <div class="mx-auto max-w-lg space-y-8">
                @if ($errorMessage)
                    <x-panel.danger title="Error connecting to your database" icon="tabler-alert-circle">
                        {{ $errorMessage }}
                    </x-panel.danger>
                @endif

                <fieldset>
                    <div class="isolate -space-y-px rounded-lg shadow-sm">
                        <div
                            class="relative rounded-lg rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                        >
                            <label
                                for="db-username"
                                @class([
                                    'block text-xs font-medium',
                                    'text-gray-900' => ! $errors->has('username'),
                                    'text-danger-600' => $errors->has('username'),
                                ])
                            >
                                Username
                            </label>
                            <input
                                type="text"
                                name="db-username"
                                id="db-username"
                                class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="Your database username"
                                wire:model.defer="username"
                            />
                            @error('username')
                                <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                    {{-- format-ignore-start --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    {{-- format-ignore-end --}}

                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div
                            class="relative rounded-lg rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                        >
                            <label
                                for="db-password"
                                @class([
                                    'block text-xs font-medium',
                                    'text-gray-900' => ! $errors->has('password'),
                                    'text-danger-600' => $errors->has('password'),
                                ])
                            >
                                Password
                            </label>
                            <input
                                type="password"
                                name="db-password"
                                id="db-password"
                                class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="Your database password"
                                wire:model.defer="password"
                            />
                            @error('password')
                                <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                    {{-- format-ignore-start --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    {{-- format-ignore-end --}}

                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="isolate -space-y-px rounded-lg shadow-sm">
                        <div
                            class="relative rounded-lg rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                        >
                            <label
                                for="db-name"
                                @class([
                                    'block text-xs font-medium',
                                    'text-gray-900' => ! $errors->has('database'),
                                    'text-danger-600' => $errors->has('database'),
                                ])
                            >
                                Database name
                            </label>
                            <input
                                type="text"
                                name="db-name"
                                id="db-name"
                                class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="The name of your database"
                                wire:model.defer="database"
                            />
                            @error('database')
                                <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                    {{-- format-ignore-start --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    {{-- format-ignore-end --}}

                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div
                            class="relative rounded-lg rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                        >
                            <label for="db-prefix" class="block text-xs font-medium text-gray-900">Table prefix</label>
                            <input
                                type="text"
                                name="db-prefix"
                                id="db-prefix"
                                class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="The table prefix (optional)"
                                wire:model.defer="prefix"
                            />
                        </div>
                    </div>

                    <p class="mt-2 px-1 text-sm/6 text-gray-500">
                        If you’re planning to install other applications into the same database
                        <strong class="font-semibold text-gray-600">or</strong>
                        you’re migrating from Nova 2 and using the same database, you’ll want to add a table prefix such
                        as
                        <strong class="font-semibold text-gray-600">nova3_</strong>
                    </p>
                </fieldset>

                <fieldset
                    x-data="{ expanded: false }"
                    x-on:advanced-settings-validation-error.window="expanded = true"
                >
                    <button
                        type="button"
                        x-on:click="expanded = !expanded"
                        class="flex w-full items-center justify-between gap-4 text-left text-gray-500 transition hover:text-gray-600"
                    >
                        <x-h3 class="flex-1">Advanced settings</x-h3>

                        <div class="flex items-center">
                            <x-icon name="tabler-plus" x-show="!expanded"></x-icon>
                            <x-icon name="tabler-minus" x-show="expanded"></x-icon>
                        </div>
                    </button>

                    <div class="mt-2" x-show="expanded" x-collapse x-cloak>
                        <p class="mb-4 text-gray-600">
                            In most cases you won't need to change these values unless your web host has provided you
                            different connection parameters.
                        </p>

                        <div class="isolate -space-y-px rounded-lg shadow-sm">
                            <div
                                class="relative rounded-lg rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                            >
                                <label
                                    for="db-host"
                                    @class([
                                        'block text-xs font-medium',
                                        'text-gray-900' => ! $errors->has('host'),
                                        'text-danger-600' => $errors->has('host'),
                                    ])
                                >
                                    Host
                                </label>
                                <input
                                    type="text"
                                    name="db-host"
                                    id="db-host"
                                    class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                    wire:model.defer="host"
                                />
                                @error('host')
                                    <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                        {{-- format-ignore-start --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                        {{-- format-ignore-end --}}

                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div
                                class="relative px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                            >
                                <label
                                    for="db-port"
                                    @class([
                                        'block text-xs font-medium',
                                        'text-gray-900' => ! $errors->has('port'),
                                        'text-danger-600' => $errors->has('port'),
                                    ])
                                >
                                    Port
                                </label>
                                <input
                                    type="text"
                                    name="db-port"
                                    id="db-port"
                                    class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                    wire:model.defer="port"
                                />
                                @error('port')
                                    <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                        {{-- format-ignore-start --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                        {{-- format-ignore-end --}}

                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div
                                class="relative rounded-lg rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                            >
                                <label
                                    for="db-socket"
                                    @class([
                                        'block text-xs font-medium',
                                        'text-gray-900' => ! $errors->has('socket'),
                                        'text-danger-600' => $errors->has('socket'),
                                    ])
                                >
                                    Socket
                                </label>
                                <input
                                    type="text"
                                    name="db-socket"
                                    id="db-socket"
                                    class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                    wire:model.defer="socket"
                                    placeholder="The UNIX socket path (generally not needed)"
                                />
                                @error('socket')
                                    <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                        {{-- format-ignore-start --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                        {{-- format-ignore-end --}}

                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="flex items-center justify-between">
                    <x-button.setup type="button" wire:click="connectToDatabase" size="sm">
                        <div class="flex items-center gap-3">
                            <div>Connect</div>
                            <x-icon.loader
                                class="h-5 w-5 animate-spin text-white"
                                wire:loading
                                wire:target="connectToDatabase"
                            ></x-icon.loader>
                        </div>
                    </x-button.setup>

                    <a
                        href="{{ url('setup/migrate') }}"
                        class="text-sm font-semibold leading-6 text-gray-900 hover:text-primary-600"
                    >
                        Back to migration center
                    </a>
                </div>
            </div>
        @endif

        @if ($shouldShowSuccessTable)
            <div class="mx-auto max-w-lg space-y-8">
                <x-panel class="overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @include('setup.configure-database._verify-temp-connection')
                        @include('setup.configure-database._verify-write-env')
                        @include('setup.configure-database._verify-connection')
                    </div>
                </x-panel>
            </div>

            @if ($status === DatabaseConfigStatus::success)
                <div class="flex items-center justify-center">
                    <x-button.setup href="{{ url('setup/migrate') }}" leading="tabler-database-import">
                        Continue migration
                    </x-button.setup>
                </div>
            @endif
        @endif

        @if ($shouldShowManualInstructions)
            <div class="mx-auto grid max-w-4xl grid-cols-2 gap-12 text-gray-600">
                @includeWhen($status === DatabaseConfigStatus::failedToWriteEnv, 'setup.configure-database._manual-save')
                @includeWhen($status === DatabaseConfigStatus::failedToVerify, 'setup.configure-database._manual-verify')

                <div
                    x-data="{
                        text: @js($codeForEnv),
                        copied: false,
                        copyToClipboard() {
                            this.copied = true
                            this.$clipboard(this.text)
                        },
                    }"
                    x-init="$watch('copied', (c) => c && window.setTimeout(() => (copied = false), 2000))"
                >
                    {{-- format-ignore-start --}}
                    <div class="relative flex flex-col gap-0.5 font-mono rounded-lg bg-gray-800 p-4 text-white cursor-pointer" x-on:click="copyToClipboard">
                        <div class="absolute top-4 right-4 text-xs text-gray-500 font-medium">
                            <span class="text" x-show="!copied">Click to copy</span>
                            <span class="text-success-600" x-show="copied" x-cloak>Copied!</span>
                        </div>

                        <div class="text-gray-400">DB_NOVA2_CONNECTION=<span class="text-primary-500">mysql</span></div>
                        <div class="text-gray-400">DB_NOVA2_HOST=<span class="text-primary-500">{{ $this->host }}</span></div>
                        <div class="text-gray-400">DB_NOVA2_PORT=<span class="text-primary-500">{{ $this->port }}</span></div>
                        <div class="text-gray-400">DB_NOVA2_DATABASE=<span class="text-primary-500">{{ $this->database }}</span></div>
                        <div class="text-gray-400">DB_NOVA2_USERNAME=<span class="text-primary-500">{{ $this->username }}</span></div>
                        <div class="text-gray-400">DB_NOVA2_PASSWORD=<span class="text-primary-500">{{ $this->password }}</span></div>
                        <div class="text-gray-400">DB_NOVA2_PREFIX=<span class="text-primary-500">{{ $this->prefix }}</span></div>
                        <div class="text-gray-400">DB_NOVA2_SOCKET=<span class="text-primary-500">{{ $this->socket }}</span></div>
                    </div>
                    {{-- format-ignore-end --}}
                </div>
            </div>
        @endif
    @endif
</div>
