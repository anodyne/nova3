@extends($meta->template)

@section('content')
    <div>
        <!-- Main 3 column grid -->
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
            <!-- Left column -->
            <div class="grid grid-cols-1 gap-8 lg:col-span-2">
                <!-- Welcome panel -->
                <section aria-labelledby="profile-overview-title">
                    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>

                    <div class="flex flex-col items-center md:flex-row md:justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="shrink-0">
                                <x-avatar
                                    size="lg"
                                    :src="auth()->user()->avatar_url"
                                    :tooltip="auth()->user()->name"
                                />
                            </div>
                            <div>
                                <x-text>Welcome back,</x-text>
                                <x-h1>{{ auth()->user()->name }}</x-h1>
                            </div>
                        </div>
                        <div class="mt-5 flex justify-center gap-2 md:mt-0">
                            <x-button :href="route('account.edit')" color="neutral">Go to my account</x-button>
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 divide-y divide-gray-900/5 border-t border-gray-950/5 bg-gray-50 sm:grid-cols-3 sm:divide-x sm:divide-y-0 sm:rounded-b-md dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-950/30"
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
                            href="{{ route('account.edit', 'preferences') }}"
                            class="group flex items-center justify-center space-x-3 px-6 py-5 text-center text-base font-medium transition md:text-sm"
                        >
                            <x-icon
                                name="settings"
                                size="lg"
                                class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                            ></x-icon>
                            <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Preferences</span>
                        </a>

                        <a
                            href="#"
                            class="group flex items-center justify-center space-x-3 px-6 py-5 text-center text-base font-medium transition md:text-sm"
                        >
                            <x-icon
                                name="messages"
                                size="lg"
                                class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                            ></x-icon>
                            <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">Messages</span>
                            <x-badge color="danger">3</x-badge>
                            {{-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-danger-50 text-danger-600 border border-danger-300">3</span> --}}
                        </a>
                    </div>
                </section>

                <section aria-labelledby="dashboard-stats-title">
                    <h2 class="sr-only" id="dashboard-stats-title">Stats</h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <x-panel well>
                            <x-content-box>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-badge color="info" size="lg">
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

                        <x-panel well>
                            <x-content-box>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-badge color="info" size="lg">
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

                        <x-panel well>
                            <x-content-box>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-badge color="info" size="lg">
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
                    <x-panel class="overflow-hidden rounded-2xl">
                        <div class="p-1 pb-0">
                            <img
                                src="{{ asset('dist/test4.jpg') }}"
                                alt=""
                                class="h-32 w-full rounded-md object-cover"
                            />
                        </div>

                        <div class="px-4 py-4">
                            <x-h2>Current story title</x-h2>
                            <x-text>
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur explicabo sint
                                cupiditate veritatis eaque nam modi? Soluta repellendus magnam, modi molestiae
                                aspernatur deleniti necessitatibus placeat, excepturi autem incidunt blanditiis nemo?
                            </x-text>
                        </div>
                    </x-panel>

                    <x-panel class="hidden overflow-hidden">
                        <x-content-box width="xs" height="xs">
                            <!-- Activity Feed -->
                            <div class="flow-root space-y-2 pb-4">
                                <a
                                    href="#"
                                    class="flex w-full items-baseline justify-between gap-x-2 rounded-md px-3 py-3 hover:bg-gray-100"
                                >
                                    <x-heading level="4" class="flex-1">Announcement title</x-heading>
                                    <p class="text-sm text-gray-500">Nov 28</p>
                                </a>
                                <a
                                    href="#"
                                    class="flex w-full items-baseline justify-between gap-x-2 rounded-md px-3 py-3 hover:bg-gray-100"
                                >
                                    <x-heading level="4" class="flex-1">
                                        A longer announcement title that wraps to multiple lines
                                    </x-heading>
                                    <p class="text-sm text-gray-500">Nov 28</p>
                                </a>
                            </div>
                        </x-content-box>
                    </x-panel>
                </section>

                <section class="hidden" aria-labelledby="timeline-title">
                    <x-panel>
                        <x-content-box>
                            <h2 id="timeline-title" class="text-lg font-medium text-gray-900 dark:text-white">
                                Recent Activity
                            </h2>

                            <!-- Activity Feed -->
                            <div class="mt-6 flow-root">
                                <x-timeline class="-mb-8">
                                    <x-timeline.item class="bg-gray-400 dark:bg-gray-600">
                                        <x-slot name="title">
                                            <div class="flex w-full justify-between text-base md:text-sm">
                                                <p class="font-medium text-gray-700 dark:text-gray-300">
                                                    Stanley Maura
                                                </p>
                                                <time class="text-gray-500" datetime="2020-09-20">Sep 20</time>
                                            </div>
                                        </x-slot>

                                        <div class="text-base md:text-sm">
                                            <p class="text-gray-500">Character bio updated</p>
                                        </div>
                                    </x-timeline.item>
                                    <x-timeline.item class="bg-primary-500">
                                        <x-slot name="title">
                                            <div class="flex w-full justify-between text-base md:text-sm">
                                                <p class="font-medium text-gray-700 dark:text-gray-300">
                                                    Bethany Blake
                                                </p>
                                                <time class="text-gray-500" datetime="2020-09-20">Sep 22</time>
                                            </div>
                                        </x-slot>

                                        <div class="text-base md:text-sm">
                                            <p class="text-gray-500">Published Reckoning in Episode 2</p>
                                        </div>
                                    </x-timeline.item>
                                    <x-timeline.item class="bg-success-500">
                                        <x-slot name="title">
                                            <div class="flex w-full justify-between text-base md:text-sm">
                                                <p class="font-medium text-gray-700 dark:text-gray-300">
                                                    Martha Gardner
                                                </p>
                                                <time class="text-gray-500" datetime="2020-09-20">Sep 22</time>
                                            </div>
                                        </x-slot>

                                        <div class="text-base md:text-sm">
                                            <p class="text-gray-500">Received a private message</p>
                                        </div>
                                    </x-timeline.item>
                                    <x-timeline.item class="bg-info-500" last>
                                        <x-slot name="title">
                                            <div class="flex w-full justify-between text-base md:text-sm">
                                                <p class="font-medium text-gray-700 dark:text-gray-300">
                                                    Bethany Blake
                                                </p>
                                                <time class="text-gray-500" datetime="2020-09-20">Sep 22</time>
                                            </div>
                                        </x-slot>

                                        <div class="text-base md:text-sm">
                                            <p class="text-gray-500">Published a new marker in Episode 2</p>
                                        </div>
                                    </x-timeline.item>
                                </x-timeline>
                            </div>
                            <div class="mt-6 flex flex-col justify-stretch">
                                <div>
                                    <x-button color="neutral" href="#" class="w-full">See all activity</x-button>
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
