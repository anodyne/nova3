@extends($meta->template)

@section('content')
@php
    $filesVersion = '3.0.1';
    $databaseVersion = '3.0.1';
    $serverVersion = '3.0.2';
@endphp

<div>
    <x-page-header>System Overview</x-page-header>

    <x-panel>
        <x-content-box>
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-content-box height="sm" width="sm">
                    <div class="flex items-start space-x-4">
                        <x-badge color="primary" size="square">
                            @icon('rocket', 'h-8 w-8')
                        </x-badge>

                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Nova Version</p>

                            <div class="flex items-baseline space-x-6">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $filesVersion }}
                                </p>
                                @if (version_compare($filesVersion, $serverVersion, '>='))
                                    <div class="flex items-baseline text-sm font-medium text-success-600 dark:text-success-500 space-x-1">
                                        @icon('check', 'self-center shrink-0 h-5 w-5 text-success-500 dark:text-success-400')
                                        <span>Up-to-date</span>
                                    </div>
                                @else
                                    <div class="flex items-baseline text-sm font-medium text-error-600 dark:text-error-500 space-x-1">
                                        @icon('alert', 'self-center shrink-0 h-5 w-5 text-error-500 dark:text-error-400')
                                        <span>New version available</span>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <div class="flex items-start space-x-4">
                        <x-badge color="primary" size="square">
                            @icon('database', 'h-8 w-8')
                        </x-badge>

                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Database Version</p>

                            <div class="flex items-baseline space-x-6">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $databaseVersion }}
                                </p>
                                @if (version_compare($databaseVersion, $serverVersion, '>='))
                                    <div class="flex items-baseline text-sm font-medium text-success-600 dark:text-success-500 space-x-1">
                                        @icon('check', 'self-center shrink-0 h-5 w-5 text-success-500 dark:text-success-400')
                                        <span>Up-to-date</span>
                                    </div>
                                @else
                                    <div class="flex items-baseline text-sm font-medium text-error-600 dark:text-error-500 space-x-1">
                                        @icon('alert', 'self-center shrink-0 h-5 w-5 text-error-500 dark:text-error-400')
                                        <span>New version available</span>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </x-content-box>
            </dl>

            <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium truncate">
                        PHP Version
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ PHP_VERSION }}
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium truncate">
                        Laravel Version
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ app()::VERSION }}
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium truncate">
                        Current Theme
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ app('nova.theme')->name }}
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium truncate">
                        Email Driver
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ config('mail.default') }}
                    </dd>
                </x-content-box>
            </dl>
        </x-content-box>
    </x-panel>
</div>
@endsection
