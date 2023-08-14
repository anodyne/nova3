@extends($meta->template)

@section('content')
    <div>
        <!-- Main 3 column grid -->
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
            <!-- Left column -->
            <div class="grid grid-cols-1 gap-8 lg:col-span-2">
                <!-- Welcome panel -->
                <section aria-labelledby="profile-overview-title">
                    <x-panel class="overflow-hidden">
                        <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                        <x-content-box>
                            <div class="flex flex-col items-center md:flex-row md:justify-between">
                                <div class="flex items-center space-x-5">
                                    <div class="shrink-0">
                                        <x-avatar
                                            size="lg"
                                            :src="auth()->user()->avatar_url"
                                            :tooltip="auth()->user()->name"
                                        />
                                    </div>
                                    <div class="pt-1">
                                        <p class="text-sm font-medium text-gray-500">Welcome back,</p>
                                        <p class="text-xl font-medium text-gray-900 dark:text-white sm:text-2xl">
                                            {{ auth()->user()->name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-5 flex justify-center gap-2 md:mt-0">
                                    <x-button.filled href="#" color="gray">Go to my account</x-button.filled>
                                </div>
                            </div>
                        </x-content-box>

                        <div
                            class="grid grid-cols-1 divide-y divide-gray-900/5 border-t border-gray-950/5 bg-gray-50 dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-950/30 sm:grid-cols-3 sm:divide-x sm:divide-y-0 sm:rounded-b-md"
                        >
                            <a
                                href="{{ route('characters.index', ['tableFilters' => ['only_my_characters' => ['isActive' => true]]]) }}"
                                class="group flex items-center justify-center space-x-3 px-6 py-5 text-center text-base font-medium transition md:text-sm"
                            >
                                <x-icon
                                    name="characters"
                                    size="lg"
                                    class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                                ></x-icon>
                                <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Characters</span>
                            </a>

                            <a
                                href="#"
                                class="group flex items-center justify-center space-x-3 px-6 py-5 text-center text-base font-medium transition md:text-sm"
                            >
                                <x-icon
                                    name="settings"
                                    size="lg"
                                    class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                                ></x-icon>
                                <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">
                                    Preferences
                                </span>
                            </a>

                            <a
                                href="#"
                                class="group flex items-center justify-center space-x-3 px-6 py-5 text-center text-base font-medium transition md:text-sm"
                            >
                                <x-icon
                                    name="mail"
                                    size="lg"
                                    class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                                ></x-icon>
                                <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Messages</span>
                                <x-badge color="danger">3</x-badge>
                                {{-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-danger-50 text-danger-600 border border-danger-300">3</span> --}}
                            </a>
                        </div>
                    </x-panel>
                </section>

                <section aria-labelledby="dashboard-stats-title">
                    <h2 class="sr-only" id="dashboard-stats-title">Stats</h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <x-panel>
                            <x-content-box>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-badge color="info" size="square">
                                            <x-icon name="users" size="lg"></x-icon>
                                        </x-badge>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Total Users
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">14</div>
                                    </div>
                                </div>
                            </x-content-box>
                        </x-panel>

                        <x-panel>
                            <x-content-box>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-badge color="info" size="square">
                                            <x-icon name="users" size="lg"></x-icon>
                                        </x-badge>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Total Users
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">14</div>
                                    </div>
                                </div>
                            </x-content-box>
                        </x-panel>

                        <x-panel>
                            <x-content-box>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-badge color="info" size="square">
                                            <x-icon name="users" size="lg"></x-icon>
                                        </x-badge>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            Total Users
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">14</div>
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
                            <h2 id="timeline-title" class="text-lg font-medium text-gray-900 dark:text-white">
                                Recent Activity
                            </h2>

                            <!-- Activity Feed -->
                            <div class="mt-6 flow-root">
                                <ul class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            <span
                                                class="absolute left-5 top-4 -ml-px h-full w-0.5 bg-gray-400/20 dark:bg-gray-600/50"
                                                aria-hidden="true"
                                            ></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <x-badge
                                                        size="circle"
                                                        color="gray"
                                                        class="ring-8 ring-white dark:ring-gray-800"
                                                    >
                                                        <x-icon name="user" size="md"></x-icon>
                                                    </x-badge>
                                                </div>
                                                <div class="min-w-0 flex-1 text-base md:text-sm">
                                                    <div class="flex justify-between">
                                                        <p class="font-medium text-gray-700 dark:text-gray-300">
                                                            Stanley Maura
                                                        </p>
                                                        <time class="text-gray-500" datetime="2020-09-20">Sep 20</time>
                                                    </div>
                                                    <p class="text-gray-500">Character bio updated</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="relative pb-8">
                                            <span
                                                class="absolute left-5 top-4 -ml-px h-full w-0.5 bg-gray-400/20 dark:bg-gray-600/50"
                                                aria-hidden="true"
                                            ></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <x-badge
                                                        size="circle"
                                                        color="primary"
                                                        class="ring-8 ring-white dark:ring-gray-800"
                                                    >
                                                        <x-icon name="book" size="md"></x-icon>
                                                    </x-badge>
                                                </div>
                                                <div class="min-w-0 flex-1 text-base md:text-sm">
                                                    <div class="flex justify-between">
                                                        <p class="font-medium text-gray-700 dark:text-gray-300">
                                                            Bethany Blake
                                                        </p>
                                                        <time class="text-gray-500" datetime="2020-09-22">Sep 22</time>
                                                    </div>
                                                    <p class="text-gray-500">
                                                        Published
                                                        <x-button.text href="#" color="primary" size="none">
                                                            Reckoning
                                                        </x-button.text>
                                                        story post in
                                                        <x-button.text href="#" color="primary">
                                                            Episode 2
                                                        </x-button.text>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="relative pb-8">
                                            <span
                                                class="absolute left-5 top-4 -ml-px h-full w-0.5 bg-gray-400/20 dark:bg-gray-600/50"
                                                aria-hidden="true"
                                            ></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <x-badge
                                                        size="circle"
                                                        color="success"
                                                        class="ring-8 ring-white dark:ring-gray-800"
                                                    >
                                                        <x-icon name="mail" size="md"></x-icon>
                                                    </x-badge>
                                                </div>
                                                <div class="min-w-0 flex-1 text-base md:text-sm">
                                                    <div class="flex justify-between">
                                                        <p class="font-medium text-gray-700 dark:text-gray-300">
                                                            Martha Gardner
                                                        </p>
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
                                                    <x-badge
                                                        size="circle"
                                                        color="primary"
                                                        class="ring-8 ring-white dark:ring-gray-800"
                                                    >
                                                        <x-icon name="location" size="md"></x-icon>
                                                    </x-badge>
                                                </div>
                                                <div class="min-w-0 flex-1 text-base md:text-sm">
                                                    <div class="flex justify-between">
                                                        <p class="font-medium text-gray-700 dark:text-gray-300">
                                                            Bethany Blake
                                                        </p>
                                                        <time class="text-gray-500" datetime="2020-09-22">Sep 22</time>
                                                    </div>
                                                    <p class="text-gray-500">
                                                        Published
                                                        <x-button.text href="#" color="primary">
                                                            Start of Day 3
                                                        </x-button.text>
                                                        marker in
                                                        <x-button.text href="#" color="primary">
                                                            Episode 2
                                                        </x-button.text>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-6 flex flex-col justify-stretch">
                                <div>
                                    <x-button.filled color="gray" href="#" class="w-full">
                                        See all activity
                                    </x-button.filled>
                                </div>
                            </div>
                        </x-content-box>
                    </x-panel>
                </section>
            </div>
        </div>
    </div>

    <x-tips section="dashboard" />
@endsection
