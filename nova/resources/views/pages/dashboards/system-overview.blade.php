@extends($meta->template)

@section('content')
    @php
        $filesVersion = '3.0.1';
        $databaseVersion = '3.0.1';
        $serverVersion = '3.0.2';
    @endphp

    <div>
        <x-page-header>System Overview</x-page-header>

        <div class="mb-4 grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="overflow-hidden rounded-lg border border-primary-900/10">
                <div class="px-6 py-3">
                    <x-h1>3.0.3</x-h1>
                </div>
                <div class="border-t border-primary-900/10 bg-primary-100 px-6 py-3 text-sm font-medium text-primary-600">Your version of Nova is up-to-date</div>
            </div>

            <x-panel as="extra-light-well" class="ring-1 ring-inset ring-gray-950/5">
                <x-content-box height="sm" width="sm">
                    <div class="flex items-center space-x-4">
                        <x-icon name="rocket" size="2xl" class="text-primary-500"></x-icon>

                        <div class="flex flex-col">
                            <p class="truncate text-sm font-medium text-gray-600 dark:text-gray-400">Nova Version</p>

                            <div class="flex items-baseline space-x-6">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $filesVersion }}
                                </p>
                                @if (version_compare($filesVersion, $serverVersion, '>='))
                                    <div class="flex items-center space-x-1 text-sm font-medium leading-none text-success-600 dark:text-success-500">
                                        <x-icon name="check" size="sm" class="shrink-0 self-center text-success-500 dark:text-success-400"></x-icon>
                                        <span>Up-to-date</span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-1 text-sm font-medium text-danger-600 dark:text-danger-500">
                                        <x-icon name="alert" size="sm" class="shrink-0 self-center text-danger-500 dark:text-danger-400"></x-icon>
                                        <span>New version available</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-content-box>
            </x-panel>

            <x-panel as="extra-light-well" class="ring-1 ring-inset ring-gray-950/5">
                <x-content-box height="sm" width="sm">
                    <div class="flex items-start space-x-4">
                        <x-badge color="primary" size="square">
                            <x-icon name="database" size="xl"></x-icon>
                        </x-badge>

                        <div class="flex flex-col">
                            <p class="truncate text-sm font-medium text-gray-600 dark:text-gray-400">Database Version</p>

                            <div class="flex items-baseline space-x-6">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $databaseVersion }}
                                </p>
                                @if (version_compare($databaseVersion, $serverVersion, '>='))
                                    <div class="flex items-baseline space-x-1 text-sm font-medium text-success-600 dark:text-success-500">
                                        <x-icon name="check" size="sm" class="shrink-0 self-center text-success-500 dark:text-success-400"></x-icon>
                                        <span>Up-to-date</span>
                                    </div>
                                @else
                                    <div class="flex items-baseline space-x-1 text-sm font-medium text-danger-600 dark:text-danger-500">
                                        <x-icon name="alert" size="sm" class="shrink-0 self-center text-danger-500 dark:text-danger-400"></x-icon>
                                        <span>New version available</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-content-box>
            </x-panel>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <x-content-box height="sm" width="sm">
                <dt class="truncate text-sm font-medium">PHP Version</dt>
                <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ PHP_VERSION }}
                </dd>
            </x-content-box>

            <x-content-box height="sm" width="sm">
                <dt class="truncate text-sm font-medium">Laravel Version</dt>
                <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ app()::VERSION }}
                </dd>
            </x-content-box>

            <x-content-box height="sm" width="sm">
                <dt class="truncate text-sm font-medium">Current Theme</dt>
                <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ app('nova.theme')->name }}
                </dd>
            </x-content-box>

            <x-content-box height="sm" width="sm">
                <dt class="truncate text-sm font-medium">Email Driver</dt>
                <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ config('mail.default') }}
                </dd>
            </x-content-box>
        </div>
    </div>
@endsection
