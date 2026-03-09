@use('Nova\Setup\Enums\DatabaseConfigStatus')

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Connect to your database</x-setup::page-heading>

        @if ($status === DatabaseConfigStatus::AlreadyConfigured)
            <x-setup::page-subheading>
                It looks like you’ve already configured your database connection. Next we’ll install Nova and all of its
                data.
            </x-setup::page-subheading>
        @elseif ($status === DatabaseConfigStatus::FailedToWriteEnv)
            <x-setup::page-subheading>
                We weren’t able to write your database credentials to the config file. Follow the instructions below to
                ensure Nova can connect to your database.
            </x-setup::page-subheading>
        @elseif ($status === DatabaseConfigStatus::FailedToVerify)
            <x-setup::page-subheading>
                We weren’t able to verify your database connection using the values we saved to the config file. Either
                the file was not saved correctly or your database is unavailable right now.
            </x-setup::page-subheading>
        @else
            <x-setup::page-subheading>
                Using the credentials your web host provided you when you signed up, configure your connection to the
                database here.
            </x-setup::page-subheading>
        @endif
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            @if ($errorMessage)
                <x-setup::callout.danger heading="Error connecting to your database" icon="exclamation-circle">
                    {{ $errorMessage }}
                </x-setup::callout.danger>
            @endif

            <x-fieldset>
                <x-fieldset.group>
                    <x-radio.group
                        label="Driver"
                        wire:model.live="driver"
                        variant="cards"
                        :indicator="false"
                        class="max-sm:flex-col"
                    >
                        <x-radio value="mysql" label="MySQL / MariaDB" />
                        <x-radio value="pgsql" label="PostgreSQL" />
                    </x-radio.group>

                    <x-input label="Username" placeholder="Your database username" wire:model="username" />

                    <x-input label="Password" placeholder="Your database password" wire:model="password" />

                    <x-input label="Database name" placeholder="The name of your database" wire:model="database" />

                    <x-field>
                        <x-label>Database table prefix</x-label>
                        <x-description>
                            If you’re planning to install other applications into the same database
                            <strong class="font-semibold text-gray-600">or</strong>
                            you’re migrating from Nova 2 and using the same database, you’ll want to add a table prefix
                            such as
                            <strong class="font-semibold text-gray-600">nova3_</strong>
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
                    @include('setup.configure-database._verify-compatibility')
                </x-setup::panel>
            </x-setup::panel>
        </div>
    @endif

    @if ($status === DatabaseConfigStatus::Success || $status === DatabaseConfigStatus::AlreadyConfigured)
        <div class="flex items-center justify-center">
            <x-setup::button :href="url('setup/install')" :leading="Tabler::Sparkles">Install Nova</x-setup::button>
        </div>
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
