@extends($meta->template)

@section('content')
<div>
    <h1 class="sr-only">Profile</h1>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
        <!-- Left column -->
        <div class="grid grid-cols-1 gap-8 lg:col-span-2">
            <!-- Welcome panel -->
            <section aria-labelledby="profile-overview-title">
                <x-panel class="overflow-hidden">
                    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                    <x-content-box>
                        <div class="flex flex-col md:flex-row items-center md:justify-between">
                            <div class="flex items-center space-x-5">
                                <div class="shrink-0">
                                    <x-avatar size="lg" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                                </div>
                                <div class="pt-1">
                                    <p class="text-sm font-medium text-gray-500">Welcome back,</p>
                                    <p class="text-xl font-medium text-gray-900 dark:text-gray-100 sm:text-2xl">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 flex justify-center">
                                <x-link href="#" size="xs" color="primary-outline">
                                    My Account
                                </x-link>
                            </div>
                        </div>
                    </x-content-box>

                    <div class="sm:rounded-b-md border-t border-gray-900/5 dark:border-gray-200/10 bg-gray-50 dark:bg-gray-900/40 grid grid-cols-1 divide-y divide-gray-900/5 dark:divide-gray-200/10 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                        <a href="{{ route('characters.index') }}" class="group flex items-center justify-center space-x-3 px-6 py-5 text-base md:text-sm font-medium text-center transition">
                            @icon('users', 'h-7 w-7 md:h-6 md:w-6 text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400')
                            <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Characters</span>
                        </a>

                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-base md:text-sm font-medium text-center transition">
                            @icon('settings', 'h-7 w-7 md:h-6 md:w-6 text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400')
                            <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Preferences</span>
                        </a>

                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-base md:text-sm font-medium text-center transition">
                            @icon('email', 'h-7 w-7 md:h-6 md:w-6 text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400')
                            <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Messages</span>
                            <x-badge color="error">3</x-badge>
                            {{-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-error-50 text-error-600 border border-error-300">3</span> --}}
                        </a>
                    </div>
                </x-panel>
            </section>

            <section aria-labelledby="dashboard-stats-title">
                <h2 class="sr-only" id="dashboard-stats-title">Stats</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-panel>
                        <x-content-box>
                            <div class="flex space-x-2">
                                <div>
                                    <x-badge color="info" size="square">
                                        @icon('users', 'h-7 w-7')
                                    </x-badge>
                                </div>
                                <div>
                                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">Total Users</div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        14
                                    </div>
                                </div>
                            </div>
                        </x-content-box>
                    </x-panel>

                    <x-panel>
                        <x-content-box>
                            <div class="flex space-x-2">
                                <div>
                                    <x-badge color="info" size="square">
                                        @icon('users', 'h-7 w-7')
                                    </x-badge>
                                </div>
                                <div>
                                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">Total Users</div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        14
                                    </div>
                                </div>
                            </div>
                        </x-content-box>
                    </x-panel>

                    <x-panel>
                        <x-content-box>
                            <div class="flex space-x-2">
                                <div>
                                    <x-badge color="info" size="square">
                                        @icon('users', 'h-7 w-7')
                                    </x-badge>
                                </div>
                                <div>
                                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">Total Users</div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        14
                                    </div>
                                </div>
                            </div>
                        </x-content-box>
                    </x-panel>
                </div>
            </section>
        </div>

        <!-- Right column -->
        <div class="grid grid-cols-1 gap-4">
            <section aria-labelledby="timeline-title">
                <x-panel>
                    <x-content-box>
                        <h2 id="timeline-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Recent Activity</h2>

                        <!-- Activity Feed -->
                        <div class="mt-6 flow-root">
                            <ul class="-mb-8">
                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-400/20 dark:bg-gray-600/50" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <x-badge size="circle" color="gray" class="ring-8 ring-white dark:ring-gray-800">
                                                    @icon('user', 'h-6 w-6')
                                                </x-badge>
                                            </div>
                                            <div class="min-w-0 flex-1 text-base md:text-sm">
                                                <div class="flex justify-between">
                                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Stanley Maura</p>
                                                    <time class="text-gray-500" datetime="2020-09-20">Sep 20</time>
                                                </div>
                                                <p class="text-gray-500">Character bio updated</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-400/20 dark:bg-gray-600/50" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <x-badge size="circle" color="primary" class="ring-8 ring-white dark:ring-gray-800">
                                                    @icon('book', 'h-6 w-6')
                                                </x-badge>
                                            </div>
                                            <div class="min-w-0 flex-1 text-base md:text-sm">
                                                <div class="flex justify-between">
                                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Bethany Blake</p>
                                                    <time class="text-gray-500" datetime="2020-09-22">Sep 22</time>
                                                </div>
                                                <p class="text-gray-500">Published <x-link href="#" color="primary-text" size="none">Reckoning</x-link> story post in <x-link href="#" color="primary-text" size="none">Episode 2</x-link></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-400/20 dark:bg-gray-600/50" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <x-badge size="circle" color="success" class="ring-8 ring-white dark:ring-gray-800">
                                                    @icon('email', 'h-6 w-6')
                                                </x-badge>
                                            </div>
                                            <div class="min-w-0 flex-1 text-base md:text-sm">
                                                <div class="flex justify-between">
                                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Martha Gardner</p>
                                                    <time class="text-gray-500" datetime="2020-09-28">Sep 28</time>
                                                </div>
                                                <p class="text-gray-500">Received new private message</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="relative pb-8">
                                        {{-- <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-300" aria-hidden="true"></span> --}}
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <x-badge size="circle" color="primary" class="ring-8 ring-white dark:ring-gray-800">
                                                    @icon('location', 'h-6 w-6')
                                                </x-badge>
                                            </div>
                                            <div class="min-w-0 flex-1 text-base md:text-sm">
                                                <div class="flex justify-between">
                                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Bethany Blake</p>
                                                    <time class="text-gray-500" datetime="2020-09-22">Sep 22</time>
                                                </div>
                                                <p class="text-gray-500">Published <x-link href="#" color="primary-text" size="none">Start of Day 3</x-link> marker in <x-link href="#" color="primary-text" size="none">Episode 2</x-link></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-6 flex flex-col justify-stretch">
                            <x-link href="#">See all activity</x-link>
                        </div>
                    </x-content-box>
                </x-panel>
            </section>
        </div>
    </div>
</div>

<x-tips section="dashboard" />
@endsection
