@extends($meta->template)

@section('content')
    <div>
        <section class="hidden mb-8">
            <div class="rounded-xl bg-[radial-gradient(ellipse_at_bottom,_var(--tw-gradient-stops))] from-primary-900 to-gray-900 text-white">
                <x-spacing size="md">
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-y-8 gap-x-16">
                        <div class="flex flex-col justify-between">
                            <div>
                                <div class="rounded-full inline-flex items-center bg-primary-400/10 px-3 py-1 text-xs font-medium text-primary-400 ring-1 ring-inset ring-primary-400/20">
                                    Welcome to Nova 3
                                </div>
                            </div>
                            <div class="space-y-3">
                                <h2 class="block font-[family-name:--font-header] text-xl/8 font-bold tracking-tight dark:text-gray-900 text-white">Let’s get started</h2>
                                <p class="text-sm/6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, fugiat voluptatum! Rem molestias amet unde eligendi possimus tenetur! Impedit itaque corporis quis error ipsa exercitationem earum amet facere?</p>
                            </div>
                        </div>
                        <div class="col-span-2 h-60">
                            foo
                        </div>
                    </div>
                </x-spacing>
            </div>
        </section>

        <!-- Main 3 column grid -->
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
            <!-- Left column -->
            <div class="grid grid-cols-1 gap-12 lg:col-span-2">
                <!-- Welcome panel -->
                <section aria-labelledby="profile-overview-title">
                    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>

                    <x-panel well>
                        <x-spacing size="2xs">
                            <x-panel>
                                <x-spacing size="md">
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
                                            <x-button :href="route('account.edit')" color="neutral">
                                                Go to my account
                                            </x-button>
                                        </div>
                                    </div>
                                </x-spacing>
                            </x-panel>
                        </x-spacing>

                        <x-spacing width="sm" bottom="sm" top="xs">
                            <div class="grid grid-cols-1 sm:grid-cols-3">
                                <a
                                    href="{{ route('characters.index', ['tableFilters' => ['only_my_characters' => ['isActive' => true]]]) }}"
                                    class="group flex items-center justify-center space-x-2 px-6 text-center text-base font-medium transition md:text-sm"
                                >
                                    <x-icon
                                        name="characters"
                                        size="lg"
                                        class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                                    ></x-icon>
                                    <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">
                                        Characters
                                    </span>
                                </a>

                                <a
                                    href="{{ route('account.edit', 'preferences') }}"
                                    class="group flex items-center justify-center space-x-2 px-6 text-center text-base font-medium transition md:text-sm"
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
                                    class="group flex items-center justify-center space-x-2 px-6 text-center text-base font-medium transition md:text-sm"
                                >
                                    <x-icon
                                        name="messages"
                                        size="lg"
                                        class="text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                                    ></x-icon>
                                    <span class="group-hover:text-gray-900 dark:group-hover:text-gray-100">
                                        Messages
                                    </span>
                                    <x-badge color="danger">3</x-badge>
                                    {{-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-danger-50 text-danger-600 border border-danger-300">3</span> --}}
                                </a>
                            </div>
                        </x-spacing>
                    </x-panel>
                </section>

                <section class="hidden" aria-labelledby="dashboard-stats-title">
                    <x-panel well>
                        <x-spacing size="sm">
                            <x-fieldset.legend id="dashboard-stats-title">Stats</x-fieldset.legend>
                        </x-spacing>

                        <x-spacing size="2xs">
                            <x-panel>
                                <x-spacing size="sm">
                                    <div class="grid grid-cols-1 lg:grid-cols-3">
                                        <x-panel.stat label="Active users" :value="14"></x-panel.stat>
                                        <x-panel.stat label="Active characters" :value="26"></x-panel.stat>
                                        <x-panel.stat label="Total posts" :value="715"></x-panel.stat>
                                    </div>
                                </x-spacing>
                            </x-panel>
                        </x-spacing>
                    </x-panel>
                </section>

                <section aria-labelledby="dashboard-stories-title">
                    <x-panel well>
                        <x-spacing size="2xs">
                            <x-panel class="overflow-hidden">
                                <div class="relative">
                                    <img
                                        src="{{ asset('dist/test4.jpg') }}"
                                        alt=""
                                        class="h-auto w-full object-cover"
                                    />

                                    <div
                                        class="absolute bottom-0 left-0 w-full rounded-b-lg bg-black/25 backdrop-blur-md"
                                    >
                                        <x-spacing width="sm" height="md">
                                            <x-h3 class="text-white">The Best of Both Worlds</x-h3>
                                        </x-spacing>
                                    </div>
                                </div>
                            </x-panel>

                            <x-spacing size="sm">
                                <x-text>
                                    The Borg advance their plans to assimilate the human race by kidnapping Picard and
                                    making him into their spokesman.
                                </x-text>

                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center gap-x-8">
                                        <div class="flex items-baseline gap-x-1">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">81</div>
                                            <div class="text-base text-gray-500 sm:text-sm/6">posts</div>
                                        </div>
                                        <div class="flex items-baseline gap-x-1">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">11,410</div>
                                            <div class="text-base text-gray-500 sm:text-sm/6">words</div>
                                        </div>
                                    </div>

                                    <x-button plain>Go to story &rarr;</x-button>
                                </div>
                            </x-spacing>
                        </x-spacing>
                    </x-panel>
                </section>

                <section x-data="tabsList('announcements')" aria-labelledby="dashboard-announcements-title">
                    <x-panel well>
                        <x-spacing width="xs" top="xs" bottom="2xs">
                            <x-tab.group name="posts">
                                <x-tab.heading name="announcements">Announcements</x-tab.heading>
                                <x-tab.heading name="posts">Recent posts</x-tab.heading>
                            </x-tab.group>
                        </x-spacing>

                        <div x-show="isTab('announcements')">
                            <x-spacing size="2xs">
                                <x-panel>
                                    <div class="divide-y divide-gray-950/10 dark:divide-white/10">
                                        <x-spacing size="sm" class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-h4>Announcement title</x-h4>
                                            </div>
                                            <div class="flex items-center">
                                                <x-button color="subtle-neutral" text>
                                                    <x-icon name="arrow-right" size="md"></x-icon>
                                                </x-button>
                                            </div>
                                        </x-spacing>
                                        <x-spacing size="sm" class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-h4>Announcement title</x-h4>
                                            </div>
                                            <div class="flex items-center">
                                                <x-button color="subtle-neutral" text>
                                                    <x-icon name="arrow-right" size="md"></x-icon>
                                                </x-button>
                                            </div>
                                        </x-spacing>
                                        <x-spacing size="sm" class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-h4>Announcement title</x-h4>
                                            </div>
                                            <div class="flex items-center">
                                                <x-button color="subtle-neutral" text>
                                                    <x-icon name="arrow-right" size="md"></x-icon>
                                                </x-button>
                                            </div>
                                        </x-spacing>
                                    </div>
                                </x-panel>
                            </x-spacing>

                            <x-spacing width="sm" top="2xs" bottom="xs" class="flex items-center">
                                <x-button color="heavy-neutral" text>See all announcements &rarr;</x-button>
                            </x-spacing>
                        </div>

                        <div x-show="isTab('posts')" x-cloak>
                            <x-spacing size="2xs">
                                <x-panel>
                                    <div class="divide-y divide-gray-950/10 dark:divide-white/10">
                                        <x-spacing size="sm" class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-h4>Post title</x-h4>
                                            </div>
                                            <div class="flex items-center">
                                                <x-button color="subtle-neutral" text>
                                                    <x-icon name="arrow-right" size="md"></x-icon>
                                                </x-button>
                                            </div>
                                        </x-spacing>
                                        <x-spacing size="sm" class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-h4>Post title</x-h4>
                                            </div>
                                            <div class="flex items-center">
                                                <x-button color="subtle-neutral" text>
                                                    <x-icon name="arrow-right" size="md"></x-icon>
                                                </x-button>
                                            </div>
                                        </x-spacing>
                                        <x-spacing size="sm" class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-h4>Post title</x-h4>
                                            </div>
                                            <div class="flex items-center">
                                                <x-button color="subtle-neutral" text>
                                                    <x-icon name="arrow-right" size="md"></x-icon>
                                                </x-button>
                                            </div>
                                        </x-spacing>
                                    </div>
                                </x-panel>
                            </x-spacing>

                            <x-spacing width="sm" top="2xs" bottom="xs" class="flex items-center">
                                <x-button color="heavy-neutral" text>See recent posts &rarr;</x-button>
                            </x-spacing>
                        </div>
                    </x-panel>
                </section>
            </div>

            <!-- Right column -->
            <div class="grid grid-cols-1 gap-4">
                <section aria-labelledby="timeline-title">
                    <ul role="list" class="space-y-6">
                        <li class="relative flex gap-x-4">
                            <div class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div
                                class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-900"
                            >
                                <div
                                    class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-700"
                                ></div>
                            </div>
                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900 dark:text-white">Chelsea Hagon</span>
                                published the story post
                                <em>Encounter at Farpoint.</em>
                            </p>
                            <time datetime="2023-01-23T10:32" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                                7m ago
                            </time>
                        </li>
                        <li class="relative flex gap-x-4">
                            <div class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div
                                class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-900"
                            >
                                <div
                                    class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-700"
                                ></div>
                            </div>
                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900 dark:text-white">Chelsea Hagon</span>
                                updated a character bio.
                            </p>
                            <time datetime="2023-01-23T11:03" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                                15m ago
                            </time>
                        </li>
                        <li class="relative flex gap-x-4">
                            <div class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div
                                class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-900"
                            >
                                <div
                                    class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-700"
                                ></div>
                            </div>
                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900 dark:text-white">Chelsea Hagon</span>
                                started writing a new personal post.
                            </p>
                            <time datetime="2023-01-23T11:24" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                                2h ago
                            </time>
                        </li>
                        <li class="relative flex gap-x-4">
                            <div class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div
                                class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-900"
                            >
                                <div
                                    class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-700"
                                ></div>
                            </div>
                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900 dark:text-white">Tom Cook</span>
                                started the story
                                <em>The Best of Both Worlds.</em>
                            </p>
                            <time datetime="2023-01-23T11:24" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                                12h ago
                            </time>
                        </li>
                        <li class="relative flex gap-x-4">
                            <div class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <img
                                src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt=""
                                class="relative mt-3 h-6 w-6 flex-none rounded-full bg-gray-50"
                            />
                            <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200 dark:ring-gray-700">
                                <div class="flex justify-between gap-x-4">
                                    <div class="py-0.5 text-xs leading-5 text-gray-500">
                                        <span class="font-medium text-gray-900 dark:text-white">Leslie Alexander</span>
                                        commented
                                    </div>
                                    <time
                                        datetime="2023-01-23T15:56"
                                        class="flex-none py-0.5 text-xs leading-5 text-gray-500"
                                    >
                                        1d ago
                                    </time>
                                </div>
                                <x-text>Loved the twist at the end!</x-text>
                            </div>
                        </li>
                        <li class="relative flex gap-x-4">
                            <div class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div
                                class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-900"
                            >
                                <div
                                    class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300 dark:bg-gray-800 dark:ring-gray-700"
                                ></div>
                            </div>
                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900 dark:text-white">Alex Curren</span>
                                created a new support character.
                            </p>
                            <time datetime="2023-01-24T09:12" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                                2d ago
                            </time>
                        </li>
                        <li class="relative flex gap-x-4">
                            <div class="absolute left-0 top-0 flex h-6 w-6 justify-center">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div
                                class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-900"
                            >
                                <svg
                                    class="h-6 w-6 text-primary-500"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900 dark:text-white">Alex Curren</span>
                                joined the game.
                            </p>
                            <time datetime="2023-01-24T09:20" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                                2w ago
                            </time>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </div>

    <x-tips section="dashboard" />
@endsection