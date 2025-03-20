@php
    try {
        $canVerifyDatabase = filled($e->database?->version) && filled($e->database?->driver);
    } catch (Throwable $th) {
        $canVerifyDatabase = false;
    }
@endphp

<x-spacing class="col-span-3 grid grid-cols-subgrid" size="sm">
    <div class="mr-4 shrink-0">
        <x-icon name="database" class="text-gray-500" size="xl"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h3 class="leading-8">MySQL 8.0+ or MariaDB 10.0+ or PostgreSQL 13.0+</x-h3>

        <div>
            <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
                <p>
                    Nova requires a database to store and retrieve your game’s data. Your server must be able to connect
                    to a MySQL-compatible database (such as MySQL or MariaDB) or a PostgreSQL database.
                </p>

                @if ($canVerifyDatabase)
                    <p>Your server is running {{ $e->database->platform() }}.</p>
                @else
                    <p>
                        Without a connection to the database, we cannot definitively determine if your database meets
                        the platform and version requirements. We will verify platform and version information after we
                        are able to connect to your database.
                    </p>

                    @if ($e->passes())
                        <p>Please continue to the next step to setup your database connection.</p>
                    @endif
                @endif
            </div>

            @if (! $canVerifyDatabase || ($canVerifyDatabase && $e->database->driver === 'mariadb'))
                <div class="mt-6">
                    <div class="rounded-lg bg-warning-50 px-6 py-4 ring-1 ring-inset ring-warning-500/20">
                        <x-h3 class="text-warning-700">A note about MariaDB</x-h3>

                        <p class="mt-2 text-sm/6 text-warning-600">
                            Nova does support using MariaDB instead of MySQL, however, a
                            {{-- format-ignore-start --}}
                    <a href="https://jira.mariadb.org/browse/MDEV-19077" target="_blank" class="font-medium text-warning-800 underline hover:text-warning-900">known bug</a>
                    {{-- format-ignore-end --}}
                            in MariaDB prevents calculating values from nested resources. Due to this issue, Nova hides
                            certain user interface elements with these problematic calculations if you are using
                            MariaDB. For more information, please refer to the
                            {{-- format-ignore-start --}}
                    <a href="https://anodyne-productions.com/docs/3.0/database" target="_blank" class="font-medium text-warning-800 underline hover:text-warning-900">database documentation</a>.
                    {{-- format-ignore-end --}}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($canVerifyDatabase)
            @if ($e->database->passes())
                <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
            @else
                <x-icon name="x-circle" class="text-danger-500" size="xl"></x-icon>
            @endif
        @else
            <x-icon name="help" class="text-warning-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
