@php
    use Nova\Foundation\Environment\Environment;
    use Nova\Setup\Enums\DatabaseConfigStatus;

    $e = Environment::make();

    $heading = 'Verify database compatibility';

    if ($status === DatabaseConfigStatus::IncompatibleVersion) {
        $heading = 'Incompatible database version';
    }

    if ($status === DatabaseConfigStatus::IncompatibleDriver) {
        $heading = 'Incompatible database driver';
    }
@endphp

<x-setup::panel.row :icon="Tabler::DatabaseCog" :$heading>
    @if ($status === DatabaseConfigStatus::IncompatibleVersion)
        <p>
            Your database server is running {{ $e->database->platform() }}, but Nova requires
            {{ $e->database->driverName() }} {{ $e->database->versionFor($e->database->driver) }}. Please contact your
            web host for assistance with fixing this issue.
        </p>
    @elseif ($status === DatabaseConfigStatus::IncompatibleDriver)
        <p>
            Your database server is running {{ $e->database->driverName() }}, but Nova requires MySQL, MariaDB, or
            PostgreSQL. Please contact your web host for assistance with fixing this issue.
        </p>
    @endif

    <x-slot name="trailing">
        @if ($status === DatabaseConfigStatus::IncompatibleVersion ||
             $status === DatabaseConfigStatus::IncompatibleDriver)
            <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
        @else
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
