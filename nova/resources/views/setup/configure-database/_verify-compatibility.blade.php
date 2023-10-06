@php
    use Nova\Setup\Enums\DatabaseConfigStatus;

    $e = nova()->environment();
@endphp

<x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white">
    <div class="col-span-3 font-medium text-gray-900">
        <div
            @class([
                'flex gap-4',
                'items-center' => $e->database->passes(),
            ])
        >
            <div class="shrink-0">
                <x-icon name="tabler-database-cog" size="xl" class="text-gray-500"></x-icon>
            </div>
            <div class="flex-1">
                @if ($status === DatabaseConfigStatus::incompatibleVersion)
                    <x-h4>Incompatible database version</x-h4>

                    <p class="mt-1 text-sm font-normal text-gray-500">
                        Your database server is running MySQL {{ $e->database->version }}, but Nova requires MySQL 8.0
                        or higher. Please contact your web host for assistance with fixing this issue.
                    </p>
                @elseif ($status === DatabaseConfigStatus::incompatibleDriver)
                    <x-h4>Incompatible database driver</x-h4>

                    <p class="mt-1 text-sm font-normal text-gray-500">
                        Your database server is running {{ $e->database->driverName() }}, but Nova requires MySQL.
                        Please contact your web host for assistance with fixing this issue.
                    </p>
                @else
                    <x-h4>Verify database compatibility</x-h4>
                @endif
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        @if ($status === DatabaseConfigStatus::incompatibleVersion ||
             $status === DatabaseConfigStatus::incompatibleDriver)
            <x-icon name="tabler-circle-x" class="text-danger-500" size="xl"></x-icon>
        @else
            <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
        @endif
    </div>
</x-content-box>
