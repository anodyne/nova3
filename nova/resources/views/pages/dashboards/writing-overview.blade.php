@extends($meta->template)

@section('content')
@php
    $filesVersion = '3.0.1';
    $databaseVersion = '3.0.1';
    $serverVersion = '3.0.2';
@endphp

<div>
    <x-page-header>Writing Overview</x-page-header>

    <div class="space-y-12">
        <div>
            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-panel as="well">
                    <dt>
                        <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                            @icon('info', 'h-6 w-6 text-blue-9')
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-11 truncate">Nova Version</p>
                    </dt>
                    <dd class="ml-16 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-12">
                            {{ $filesVersion }}
                        </p>
                        @if (version_compare($filesVersion, $serverVersion, '>='))
                            <p class="ml-2 flex items-baseline text-sm font-medium text-green-11">
                                @icon('check-alt', 'self-center flex-shrink-0 h-5 w-5 text-green-9')
                                <span class="ml-0.5">Up-to-date</span>
                            </p>
                        @else
                            <p class="ml-2 flex items-baseline text-sm font-medium text-blue-11">
                                @icon('alert', 'self-center flex-shrink-0 h-5 w-5 text-blue-9')
                                <span class="ml-0.5">New version available</span>
                            </p>
                        @endif
                    </dd>
                </x-panel>

                <x-panel as="well">
                    <dt>
                        <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                            @icon('database', 'h-6 w-6 text-blue-9')
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-11 truncate">Database Version</p>
                    </dt>
                    <dd class="ml-16 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-12">
                            {{ $databaseVersion }}
                        </p>

                        @if (version_compare($databaseVersion, $filesVersion, '>='))
                            <p class="ml-2 flex items-baseline text-sm font-medium text-green-11">
                                @icon('check-alt', 'self-center flex-shrink-0 h-5 w-5 text-green-9')
                                <span class="ml-0.5">Up-to-date</span>
                            </p>
                        @else
                            <p class="ml-2 flex items-baseline text-sm font-medium text-red-11">
                                @icon('alert', 'self-center flex-shrink-0 h-5 w-5 text-red-9')
                                <span class="ml-0.5">Update required</span>
                            </p>
                        @endif
                    </dd>
                </x-panel>
            </dl>

            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <x-panel as="well">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        PHP Version
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ PHP_VERSION }}
                    </dd>
                </x-panel>

                <x-panel as="well">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        Laravel Version
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ app()::VERSION }}
                    </dd>
                </x-panel>

                <x-panel as="well">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        Current Theme
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ app('nova.theme')->name }}
                    </dd>
                </x-panel>

                <x-panel as="well">
                    <dt class="text-sm font-medium text-gray-11 truncate">
                        Email Driver
                    </dt>
                    <dd class="text-2xl font-semibold text-gray-12">
                        {{ config('mail.default') }}
                    </dd>
                </x-panel>
            </dl>
        </div>
    </div>
</div>
@endsection
