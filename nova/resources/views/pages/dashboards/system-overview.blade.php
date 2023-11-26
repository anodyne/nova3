@extends($meta->template)

@section('content')
    @php
        $filesVersion = '3.0.1';
        $databaseVersion = '3.0.1';
        $serverVersion = '3.0.1';
    @endphp

    <div>
        <x-page-header>System Overview</x-page-header>

        <x-panel class="overflow-hidden">
            <div class="divide-y divide-gray-200 dark:divide-gray-800">
                <x-content-box>
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="flex space-x-4">
                            <x-icon name="tabler-atom" size="2xl" class="text-primary-500"></x-icon>

                            <div class="flex flex-col">
                                <p class="truncate text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Nova Version
                                </p>

                                <div class="flex items-center gap-6">
                                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
                                        {{ $filesVersion }}
                                    </h2>
                                    <div>
                                        @if (version_compare($filesVersion, $serverVersion, '>='))
                                            <x-badge color="success">Up-to-date</x-badge>
                                        @else
                                            <x-badge color="danger">New version available</x-badge>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <x-icon name="database" size="2xl" class="text-primary-500"></x-icon>

                            <div class="flex flex-col">
                                <p class="truncate text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Database Version
                                </p>

                                <div class="flex items-center gap-6">
                                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
                                        {{ $databaseVersion }}
                                    </h2>
                                    <div>
                                        @if (version_compare($databaseVersion, $serverVersion, '>='))
                                            <x-badge color="success">Up-to-date</x-badge>
                                        @else
                                            <x-badge color="danger">New version available</x-badge>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-content-box>

                @if (version_compare($filesVersion, $serverVersion, '!='))
                    <x-content-box class="relative">
                        <div class="absolute right-6 top-6">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger" color="subtle-neutral">
                                    <x-icon name="x" size="lg"></x-icon>
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to ignore this update? You won't be prompted to update
                                        again until a new version is released.
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="tabler-bell-off">
                                        Ignore
                                    </x-dropdown.item-danger>
                                    <x-dropdown.item
                                        type="button"
                                        icon="prohibited"
                                        x-on:click.prevent="$dispatch('dropdown-close')"
                                    >
                                        Cancel
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            </x-dropdown>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="shrink-0">
                                <x-icon name="tabler-refresh-dot" size="xl"></x-icon>
                            </div>
                            <x-h1>Nova {{ $serverVersion }}</x-h1>
                        </div>

                        <div class="ml-[2.75rem] mt-4">
                            <p class="max-w-2xl text-lg/8">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum quos corporis suscipit
                                odio rerum illo porro officiis quod quis fugiat aliquid, esse, culpa, repellat dicta
                                nemo minus ipsam iusto nihil?
                            </p>

                            <div class="mt-8 flex items-center gap-4">
                                <x-button.filled color="primary">Get the update files &rarr;</x-button.filled>
                                <x-button.filled color="neutral">Learn more</x-button.filled>
                            </div>
                        </div>
                    </x-content-box>
                @endif

                <x-content-box class="bg-gray-50 dark:bg-gray-950/30">
                    <div class="grid grid-cols-1 lg:grid-cols-4">
                        <div class="flex">
                            <x-icon name="tabler-brand-php" size="2xl" class="text-[#777bb3]"></x-icon>

                            <x-panel.stat label="PHP version">
                                {{ PHP_VERSION }}
                            </x-panel.stat>
                        </div>
                        <div class="flex">
                            <x-icon name="tabler-brand-laravel" size="2xl" class="text-[#f9322c]"></x-icon>

                            <x-panel.stat label="Laravel version">
                                {{ app()::VERSION }}
                            </x-panel.stat>
                        </div>
                        <x-panel.stat label="Current theme">
                            {{ app('nova.theme')->name }}
                        </x-panel.stat>
                        <x-panel.stat label="Email driver">
                            {{ config('mail.default') }}
                        </x-panel.stat>
                    </div>
                </x-content-box>
            </div>
        </x-panel>
    </div>
@endsection
