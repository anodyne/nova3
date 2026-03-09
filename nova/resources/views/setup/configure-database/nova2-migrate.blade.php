@use('Nova\Setup\Enums\DatabaseConfigStatus')

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Migrate from Nova 2</x-setup::page-heading>

        @if ($status === DatabaseConfigStatus::AlreadyConfigured)
            <x-setup::page-subheading>
                It looks like you’ve already configured your database connection. Next we’ll migrate your Nova 2 data to
                the new format.
            </x-setup::page-subheading>
        @elseif ($status === DatabaseConfigStatus::FailedToWriteEnv)
            <x-setup::page-subheading>
                We weren’t able to write your database credentials to the config file. Follow the instructions below to
                ensure Nova can connect to the database where Nova 2 is installed.
            </x-setup::page-subheading>
        @elseif ($status === DatabaseConfigStatus::FailedToVerify)
            <x-setup::page-subheading>
                We weren’t able to verify your database connection using the values we saved to the config file. Either
                the file was not saved correctly or your database is unavailable right now.
            </x-setup::page-subheading>
        @else
            <x-setup::page-subheading>
                When migrating from Nova 2, you can pull your data from the same database where Nova 3 is installed or
                you can specify a different database where your Nova 2 data lives.
            </x-setup::page-subheading>
        @endif
    </header>

    @if ($status === DatabaseConfigStatus::AlreadyConfigured)
        <div class="flex items-center justify-center">
            <x-setup::button href="{{ url('setup/migrate') }}" :leading="Tabler::DatabaseImport">
                Continue migration
            </x-setup::button>
        </div>
    @endif

    @if ($shouldShowDatabaseOptions)
        <div class="mx-auto max-w-2xl space-y-8">
            <div class="grid grid-cols-2 gap-8">
                <x-button wire:click="useSameDatabaseForMigration">
                    <x-spacing size="md" class="space-y-2 text-left">
                        <x-icon :name="Tabler::Database" size="xl" class="text-gray-600" />
                        <x-h3>Use the same database</x-h3>
                        <p class="text-sm/6 font-normal text-gray-600">
                            Your Nova 2 database tables live in the same database that you are installing Nova 3 into.
                        </p>
                    </x-spacing>
                </x-button>

                <x-button wire:click="useDifferentDatabaseForMigration">
                    <x-spacing size="md" class="space-y-2 text-left">
                        <x-icon :name="Tabler::DatabaseExport" size="xl" class="text-gray-600" />
                        <x-h3>Use a different database</x-h3>
                        <p class="text-sm/6 font-normal text-gray-600">
                            Your Nova 2 database tables live in a separate database from the one you are installing Nova
                            3 into.
                        </p>
                    </x-spacing>
                </x-button>
            </div>

            <div class="flex flex-col items-center">
                <x-button :href="url('setup/migrate')">Back to migration center</x-button>
            </div>
        </div>
    @else
        @if ($shouldShowForm)
            <div class="mx-auto max-w-lg space-y-12">
                @if ($errorMessage)
                    <x-callout.danger heading="Error connecting to your database" :icon="Tabler::AlertCircle">
                        {{ $errorMessage }}
                    </x-callout.danger>
                @endif

                <x-fieldset>
                    <x-fieldset.group>
                        <x-input label="Username" placeholder="Your database username" wire:model="username" />

                        <x-input.password label="Password" placeholder="Your database password" wire:model="password" />

                        <x-input label="Database name" placeholder="The name of your database" wire:model="database" />

                        <x-field>
                            <x-label>Database table prefix</x-label>
                            <x-description>
                                If you’re planning to install other applications into the same database
                                <strong class="text-gray-600">or</strong>
                                you’re migrating from Nova 2 and using the same database, you’ll want to add a table
                                prefix such as
                                <strong class="text-gray-600">nova3_</strong>
                            </x-description>

                            <x-input placeholder="The database table prefix (optional)" wire:model="prefix" />
                        </x-field>
                    </x-fieldset.group>
                </x-fieldset>

                <x-fieldset>
                    <x-fieldset.heading :icon="Tabler::DatabaseCog" heading="Advanced settings">
                        <x-description>
                            In most cases you won’t need to change these values unless your web host has provided you
                            different connection parameters.
                        </x-description>
                    </x-fieldset.heading>

                    <x-fieldset.group>
                        <x-input label="Database host" wire:model="host" />

                        <x-input label="Database port" wire:model="port" />

                        <x-input
                            label="Database socket"
                            placeholder="The UNIX socket path (generally not needed)"
                            wire:model="socket"
                        />
                    </x-fieldset.group>
                </x-fieldset>

                <div class="flex items-center justify-between">
                    <x-setup::button type="button" wire:click="connectToDatabase" size="sm">
                        <div class="flex items-center gap-3">
                            <div>Connect</div>
                            <x-icon.loader
                                class="size-5 animate-spin text-white"
                                wire:loading
                                wire:target="connectToDatabase"
                            ></x-icon.loader>
                        </div>
                    </x-setup::button>

                    <a
                        href="{{ url('setup/migrate') }}"
                        class="hover:text-primary-600 text-sm leading-6 font-semibold text-gray-900"
                    >
                        Back to migration center
                    </a>
                </div>
            </div>
        @endif

        @if ($shouldShowSuccessTable)
            <div class="mx-auto max-w-lg space-y-8">
                <x-setup::panel variant="well">
                    <x-setup::panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                        @include('setup.configure-database._verify-temp-connection')
                        @include('setup.configure-database._verify-write-env')
                        @include('setup.configure-database._verify-connection')
                    </x-setup::panel>
                </x-setup::panel>
            </div>

            @if ($status === DatabaseConfigStatus::Success)
                <div class="flex items-center justify-center">
                    <x-setup::button href="{{ url('setup/migrate') }}" :leading="Tabler::DatabaseImport">
                        Continue migration
                    </x-setup::button>
                </div>
            @endif
        @endif

        @if ($shouldShowManualInstructions)
            <div class="mx-auto grid max-w-4xl grid-cols-2 gap-12 text-gray-600">
                @includeWhen($status === DatabaseConfigStatus::FailedToWriteEnv, 'setup.configure-database._manual-save')
                @includeWhen($status === DatabaseConfigStatus::FailedToVerify, 'setup.configure-database._manual-verify')

                <div
                    x-data="{
                        text: {{ Js::from($codeForEnv) }},
                        copied: false,
                        copyToClipboard() {
                            this.copied = true
                            this.$clipboard(this.text)
                        },
                    }"
                    x-init="$watch('copied', (c) => c && window.setTimeout(() => (copied = false), 2000))"
                >
                    {{-- format-ignore-start --}}
                    <div class="relative flex flex-col gap-0.5 font-mono rounded-xl bg-gray-900 p-4 text-white cursor-pointer text-sm/6" x-on:click="copyToClipboard">
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
