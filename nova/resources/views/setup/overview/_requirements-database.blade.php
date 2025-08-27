@php
    try {
        $canVerifyDatabase = filled($e->database?->version) && filled($e->database?->driver);
    } catch (Throwable $th) {
        $canVerifyDatabase = false;
    }
@endphp

<x-setup::panel.row :icon="Tabler::Database" heading="MySQL 8.0+ or MariaDB 10.2.7+ or PostgreSQL 13.0+">
    <p>
        Nova requires a database to store and retrieve your game’s data. Your server must be able to connect to a
        MySQL-compatible database (such as MySQL or MariaDB) or a PostgreSQL database.
    </p>

    @if ($canVerifyDatabase)
        <p>Your server is running {{ $e->database->platform() }}.</p>
    @else
        <p>
            Without a connection to the database, we cannot definitively determine if your database meets the platform
            and version requirements. We will verify platform and version information after we are able to connect to
            your database.
        </p>

        @if ($e->passes())
            <p>Please continue to the next step to setup your database connection.</p>
        @endif
    @endif

    @if (! $canVerifyDatabase || ($canVerifyDatabase && $e->database->driver === 'mysql'))
        <div class="mt-6">
            <x-setup::callout.warning heading="A note about MariaDB">
                <p>
                    Nova does support using MariaDB instead of MySQL, however, a
                    {{-- format-ignore-start --}}
                    <a href="https://jira.mariadb.org/browse/MDEV-19077" target="_blank" class="font-medium text-warning-800 underline hover:text-warning-900">known bug</a>
                    {{-- format-ignore-end --}}
                    in MariaDB prevents calculating values from nested resources. Due to this issue, Nova hides certain
                    user interface elements with these problematic calculations if you are using MariaDB. For more
                    information, please refer to the
                    {{-- format-ignore-start --}}
                    <a href="https://anodyne-productions.com/docs/3.0/database" target="_blank" class="font-medium text-warning-800 underline hover:text-warning-900">database documentation</a>.
                    {{-- format-ignore-end --}}
                </p>
            </x-setup::callout.warning>
        </div>
    @endif

    <x-slot name="trailing">
        @if ($canVerifyDatabase)
            @if ($e->database->passes())
                <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
            @else
                <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
            @endif
        @else
            <x-icon :name="Tabler::HelpCircle" class="text-warning-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
