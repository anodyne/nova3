@php
    use Nova\Foundation\Environment\Environment;
    use Nova\Setup\Enums\DatabaseConfigStatus;

    $e = Environment::make();
@endphp

<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon name="database-settings" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2">
        @if ($status === DatabaseConfigStatus::IncompatibleVersion)
            <x-h4 class="leading-8">Incompatible database version</x-h4>

            <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
                <p>
                    Your database server is running {{ $e->database->platform() }}, but Nova requires
                    {{ $e->database->driverName() }} {{ $e->database->versionFor($e->database->driver) }}. Please
                    contact your web host for assistance with fixing this issue.
                </p>
            </div>
        @elseif ($status === DatabaseConfigStatus::IncompatibleDriver)
            <x-h4 class="leading-8">Incompatible database driver</x-h4>

            <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
                <p>
                    Your database server is running {{ $e->database->driverName() }}, but Nova requires MySQL, MariaDB,
                    or PostgreSQL. Please contact your web host for assistance with fixing this issue.
                </p>
            </div>
        @else
            <x-h4 class="leading-8">Verify database compatibility</x-h4>
        @endif
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($status === DatabaseConfigStatus::IncompatibleVersion ||
             $status === DatabaseConfigStatus::IncompatibleDriver)
            <x-icon name="x-circle" class="text-danger-500" size="xl"></x-icon>
        @else
            <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
