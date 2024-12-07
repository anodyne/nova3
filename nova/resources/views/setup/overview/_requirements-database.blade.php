@php
    $canVerifyDatabase = filled($e->database->version) && filled($e->database->driver);
@endphp

<x-spacing size="sm">
    <div class="flex justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-icon name="tabler-database" class="text-gray-500" size="xl"></x-icon>
            </div>
            <x-h3 class="flex-1">MySQL 8.0+ or MariaDB 10.0+</x-h3>
        </div>

        @if ($canVerifyDatabase)
            <div class="flex justify-end">
                @if ($e->database->passes())
                    <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
                @else
                    <x-icon name="tabler-circle-x" class="text-danger-500" size="xl"></x-icon>
                @endif
            </div>
        @endif
    </div>
    <div class="ml-12 mt-2 max-w-lg space-y-4 text-sm/6 font-normal text-gray-500">
        <p>
            Nova requires a database to store and retrieve your game’s data. Your server has the ability to connect to a
            MySQL-compatible database.
        </p>

        @if ($canVerifyDatabase)
            <p>Your server is running {{ $e->database->platform() }}.</p>
        @else
            <p>
                Without a connection to the database, we cannot definitively determine if your database meets the
                platform and version requirements. We will verify platform and version information after connecting to
                the database in the next step.
            </p>
        @endif
    </div>

    @if (! $canVerifyDatabase || ($canVerifyDatabase && $e->database->driver === 'mariadb'))
        <div class="ml-12 mt-6">
            <div class="rounded-lg bg-warning-50 px-6 py-4 ring-1 ring-inset ring-warning-500/20">
                <x-h3 class="text-warning-700">A note about MariaDB</x-h3>

                <p class="mt-2 text-sm/6 text-warning-600">
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
            </div>
        </div>
    @endif
</x-spacing>
