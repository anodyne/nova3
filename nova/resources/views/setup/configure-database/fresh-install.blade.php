@php
    use Nova\Setup\Enums\DatabaseConfigStatus;
@endphp

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Connect to your database</h1>

        @if ($status === DatabaseConfigStatus::alreadyConfigured)
            <p class="text-lg/8 text-gray-600">
                It looks like you’ve already configured your database connection. Next we’ll install Nova and all of its
                data.
            </p>
        @elseif ($status === DatabaseConfigStatus::failedToWriteEnv)
            <p class="text-lg/8 text-gray-600">
                We weren’t able to write your database credentials to the config file. Follow the instructions below to
                ensure Nova can connect to your database.
            </p>
        @elseif ($status === DatabaseConfigStatus::failedToVerify)
            <p class="text-lg/8 text-gray-600">
                We weren’t able to verify your database connection using the values we saved to the config file. Either
                the file was not saved correctly or your database is unavailable right now.
            </p>
        @else
            <p class="text-lg/8 text-gray-600">
                Using the credentials your web host provided you when you signed up, configure your connection to the
                database here.
            </p>
        @endif
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            @if ($errorMessage)
                <x-panel.danger title="Error connecting to your database" icon="tabler-alert-circle">
                    {{ $errorMessage }}
                </x-panel.danger>
            @endif

            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Username"
                        id="db_username"
                        name="db_username"
                        :error="$errors->first('username')"
                    >
                        <x-input.text placeholder="Your database username" wire:model="username"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Password"
                        id="db_password"
                        name="db_password"
                        :error="$errors->first('password')"
                    >
                        <x-input.password placeholder="Your database password" wire:model="password"></x-input.password>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Database name"
                        id="db_name"
                        name="db_name"
                        :error="$errors->first('database')"
                    >
                        <x-input.text placeholder="The name of your database" wire:model="database"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Database table prefix" id="db_prefix" name="db_prefix">
                        <x-slot name="description">
                            If you’re planning to install other applications into the same database
                            <strong class="font-semibold text-gray-600">or</strong>
                            you’re migrating from Nova 2 and using the same database, you’ll want to add a table prefix
                            such as
                            <strong class="font-semibold text-gray-600">nova3_</strong>
                        </x-slot>

                        <x-input.text
                            placeholder="The database table prefix (optional)"
                            wire:model="prefix"
                        ></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="tabler-database-cog"></x-icon>
                    <x-fieldset.legend>Advanced settings</x-fieldset.legend>
                    <x-fieldset.description>
                        In most cases you won’t need to change these values unless your web host has provided you
                        different connection parameters.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Database host"
                        id="db_host"
                        name="db_host"
                        :error="$errors->first('host')"
                    >
                        <x-input.text wire:model="host"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Database port"
                        id="db_port"
                        name="db_port"
                        :error="$errors->first('port')"
                    >
                        <x-input.text wire:model="port"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Database socket"
                        id="db_socket"
                        name="db_socket"
                        :error="$errors->first('socket')"
                    >
                        <x-input.text
                            placeholder="The UNIX socket path (generally not needed)"
                            wire:model="socket"
                        ></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <div class="flex items-center justify-between">
                <x-button.setup type="button" wire:click="connectToDatabase" size="sm">
                    <div class="flex items-center gap-3">
                        <div>Connect</div>
                        <x-icon.loader
                            class="size-5 animate-spin text-white"
                            wire:loading
                            wire:target="connectToDatabase"
                        ></x-icon.loader>
                    </div>
                </x-button.setup>
            </div>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel well>
                <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5">
                        @include('setup.configure-database._verify-temp-connection')
                        @include('setup.configure-database._verify-write-env')
                        @include('setup.configure-database._verify-connection')
                        @include('setup.configure-database._verify-compatibility')
                    </x-panel>
                </x-spacing>
            </x-panel>
        </div>
    @endif

    @if ($status === DatabaseConfigStatus::success || $status === DatabaseConfigStatus::alreadyConfigured)
        <div class="flex items-center justify-center">
            <x-button.setup :href="url('setup/install')" leading="tabler-sparkles">Install Nova</x-button.setup>
        </div>
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

                    <div class="text-gray-400">DB_CONNECTION=<span class="text-primary-500">mysql</span></div>
                    <div class="text-gray-400">DB_HOST=<span class="text-primary-500">{{ $this->host }}</span></div>
                    <div class="text-gray-400">DB_PORT=<span class="text-primary-500">{{ $this->port }}</span></div>
                    <div class="text-gray-400">DB_DATABASE=<span class="text-primary-500">{{ $this->database }}</span></div>
                    <div class="text-gray-400">DB_USERNAME=<span class="text-primary-500">{{ $this->username }}</span></div>
                    <div class="text-gray-400">DB_PASSWORD=<span class="text-primary-500">{{ $this->password }}</span></div>
                    <div class="text-gray-400">DB_PREFIX=<span class="text-primary-500">{{ $this->prefix }}</span></div>
                    <div class="text-gray-400">DB_SOCKET=<span class="text-primary-500">{{ $this->socket }}</span></div>
                </div>
                {{-- format-ignore-end --}}
            </div>
        </div>
    @endif
</div>
