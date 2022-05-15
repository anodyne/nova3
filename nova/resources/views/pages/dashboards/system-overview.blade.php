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
                        <x-badge color="blue" size="square-sm">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"><g stroke-linecap="round" stroke-width="1" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M17.09 12.12l-5.4 4.31h-.001c-.4.31-.98.28-1.34-.08l-2.74-2.74v0c-.37-.37-.4-.94-.08-1.34l4.31-5.4v0c1.97-2.47 4.96-3.91 8.12-3.91v0 0c.55 0 1 .44 1 1v0h-.001c0 3.16-1.44 6.14-3.91 8.12Z"/><path d="M16 13v4.38h-.001c-.01.37-.22.72-.56.89l-2.42 1.2v0c-.5.24-1.1.04-1.35-.45 -.03-.05-.04-.09-.06-.14l-.64-1.91"/><path d="M7 13l-1.91-.64v0c-.53-.18-.81-.75-.64-1.27 .01-.05.03-.09.05-.14l1.2-2.42h0c.16-.34.51-.56.89-.56h4.38"/><path d="M5.75 20.58l-2.76.41 .41-2.76H3.39c.13-.9.83-1.6 1.72-1.73v0 -.001c1.12-.17 2.16.6 2.33 1.72 .03.2.03.4-.001.61v0l0-.001c-.14.89-.84 1.59-1.73 1.72Z"/></g><path fill="none" d="M0 0h24v24H0Z"/></svg>
                        </x-badge>

                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Nova Version</p>

                            <div class="flex items-baseline space-x-6">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $filesVersion }}
                                </p>
                                @if (version_compare($filesVersion, $serverVersion, '>='))
                                    <div class="flex items-baseline text-sm font-medium text-green-600 dark:text-green-500 space-x-1">
                                        @icon('check', 'self-center shrink-0 h-5 w-5 text-green-500 dark:text-green-400')
                                        <span>Up-to-date</span>
                                    </div>
                                @else
                                    <div class="flex items-baseline text-sm font-medium text-red-600 dark:text-red-500 space-x-1">
                                        @icon('alert', 'self-center shrink-0 h-5 w-5 text-red-500 dark:text-red-400')
                                        <span>New version available</span>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </x-content-box>

                <x-content-box height="sm" width="sm">
                    <div class="flex items-start space-x-4">
                        <x-badge color="blue" size="square-sm">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"><g stroke-linecap="round" stroke-width="1" stroke="currentColor" fill="none" stroke-linejoin="round"><path d="M20.976 11.619l-.68-5.957C20.116 4.146 18.836 3 17.316 3H6.67C5.14 3 3.86 4.146 3.69 5.662l-.68 5.957"/><path d="M18 15H6c-1.657 0-3 1.343-3 3v0c0 1.657 1.343 3 3 3h12c1.657 0 3-1.343 3-3v0c0-1.657-1.343-3-3-3Z"/><path d="M18 9H6c-1.657 0-3 1.343-3 3v0c0 1.657 1.343 3 3 3h12c1.657 0 3-1.343 3-3v0c0-1.657-1.343-3-3-3Z"/><path d="M11 12h7"/><path d="M6.03 11.96c.01.01.01.05 0 .07 -.02.01-.06.01-.08 0 -.02-.02-.02-.06 0-.08 .01-.02.05-.02.07 0"/><path d="M11.07 18h7"/><path d="M6.1 17.96c.01.01.01.05 0 .07 -.02.01-.06.01-.08 0 -.02-.02-.02-.06 0-.08 .01-.02.05-.02.07 0"/></g><path fill="none" d="M0 0h24v24H0V0Z"/></svg>
                        </x-badge>

                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Database Version</p>

                            <div class="flex items-baseline space-x-6">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $databaseVersion }}
                                </p>
                                @if (version_compare($databaseVersion, $serverVersion, '>='))
                                    <div class="flex items-baseline text-sm font-medium text-green-600 dark:text-green-500 space-x-1">
                                        @icon('check', 'self-center shrink-0 h-5 w-5 text-green-500 dark:text-green-400')
                                        <span>Up-to-date</span>
                                    </div>
                                @else
                                    <div class="flex items-baseline text-sm font-medium text-red-600 dark:text-red-500 space-x-1">
                                        @icon('alert', 'self-center shrink-0 h-5 w-5 text-red-500 dark:text-red-400')
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
