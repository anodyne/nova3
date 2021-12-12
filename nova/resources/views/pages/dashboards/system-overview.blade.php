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
                <x-content-box height="sm" width="sm" class="bg-blue-3 border border-blue-6 rounded-md">
                    <dt>
                        <div class="absolute">
                            @icon('info', 'h-8 w-8 text-blue-9')
                        </div>
                        <p class="ml-12 text-sm font-medium text-blue-11 truncate">Nova Version</p>
                    </dt>
                    <dd class="ml-12 flex items-baseline">
                        <p class="text-2xl font-semibold text-blue-12">
                            {{ $filesVersion }}
                        </p>
                        @if (version_compare($filesVersion, $serverVersion, '>='))
                            <p class="ml-2 flex items-baseline text-sm font-medium text-green-11">
                                @icon('check', 'self-center shrink-0 h-5 w-5 text-green-9')
                                <span class="ml-0.5">Up-to-date</span>
                            </p>
                        @else
                            <p class="ml-2 flex items-baseline text-sm font-medium text-blue-11">
                                @icon('alert', 'self-center shrink-0 h-5 w-5 text-blue-9')
                                <span class="ml-0.5">New version available</span>
                            </p>
                        @endif
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm" class="bg-red-3 border border-red-6 rounded-md">
                    <dt>
                        <div class="absolute">
                            @icon('info', 'h-8 w-8 text-red-9')
                        </div>
                        <p class="ml-12 text-sm font-medium text-red-11 truncate">Database Version</p>
                    </dt>
                    <dd class="ml-12 flex items-baseline">
                        <p class="text-2xl font-semibold text-red-12">
                            {{ $filesVersion }}
                        </p>
                        @if (version_compare($filesVersion, $serverVersion, '>='))
                            <p class="ml-2 flex items-baseline text-sm font-medium text-green-11">
                                @icon('check', 'self-center shrink-0 h-5 w-5 text-green-9')
                                <span class="ml-0.5">Up-to-date</span>
                            </p>
                        @else
                            <p class="ml-2 flex items-baseline text-sm font-medium text-red-11">
                                @icon('alert', 'self-center shrink-0 h-5 w-5 text-red-9')
                                <span class="ml-0.5">New version available</span>
                            </p>
                        @endif
                    </dd>
                </x-content-box>
            </dl>

            <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        PHP Version
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ PHP_VERSION }}
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        Laravel Version
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ app()::VERSION }}
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        Current Theme
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ app('nova.theme')->name }}
                    </dd>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        Email Driver
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ config('mail.default') }}
                    </dd>
                </x-content-box>
            </dl>
        </x-content-box>
    </x-panel>
</div>
@endsection
