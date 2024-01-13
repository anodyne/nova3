<x-spacing height="sm" class="bg-white">
    <div class="flex justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-icon name="tabler-brand-mysql" class="text-gray-500" size="xl"></x-icon>
            </div>
            <x-h3 class="flex-1">MySQL 8.0+</x-h3>
        </div>
        <div class="flex justify-end">
            <x-icon name="tabler-alert-triangle" class="text-warning-500" size="xl"></x-icon>
        </div>
    </div>
    <div class="ml-12 mt-2 max-w-lg space-y-4 text-sm font-normal text-gray-500">
        <p>
            Nova requires a MySQL database to store and retrieve your game's data. Your server has the ability to
            connect to a MySQL database.
        </p>

        <p>
            Without a connection to the database, we cannot definitively determine if your database meets the version
            requirements. We will verify version information after connecting to the database in the next step.
        </p>
    </div>
    <div class="ml-12 mt-6">
        {{-- format-ignore-start --}}
        <x-panel.warning title="Please note">
            At this time, Nova does not support MariaDB. While it’s often considered a drop-in replacement for MySQL, a <a href="https://jira.mariadb.org/browse/MDEV-19077" target="_blank" class="font-medium text-warning-800 underline hover:text-warning-900">known bug</a> in MariaDB would prevent some of Nova’s core features from working correctly. When this bug has been adequately addressed, we will update Nova’s database requirements.
        </x-panel.warning>
        {{-- format-ignore-end --}}
    </div>
</x-spacing>
