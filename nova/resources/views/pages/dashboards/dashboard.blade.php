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
                <x-panel>
                    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                    <x-content-box>
                        <div class="flex flex-col md:flex-row items-center md:justify-between">
                            <div class="flex items-center space-x-5">
                                <div class="shrink-0">
                                    <x-avatar size="lg" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                                </div>
                                <div class="pt-1">
                                    <p class="text-sm font-medium text-gray-11">Welcome back,</p>
                                    <p class="text-xl font-medium text-gray-12 sm:text-2xl">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 flex justify-center">
                                <x-link href="#" size="xs" color="blue-outline">
                                    My account
                                </x-link>
                            </div>
                        </div>
                    </x-content-box>

                    <div class="sm:rounded-b-md border-t border-gray-6 bg-gray-2 grid grid-cols-1 divide-y divide-gray-6 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                        <a href="{{ route('characters.index') }}" class="group flex items-center justify-center space-x-3 px-6 py-5 text-base md:text-sm font-medium text-center transition-all ease-in-out duration-200">
                            @icon('users', 'h-7 w-7 md:h-6 md:w-6 text-gray-9 group-hover:text-gray-10')
                            <span class="text-gray-11 group-hover:text-gray-12">Characters</span>
                        </a>

                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-base md:text-sm font-medium text-center transition-all ease-in-out duration-200">
                            @icon('preferences', 'h-7 w-7 md:h-6 md:w-6 text-gray-9 group-hover:text-gray-10')
                            <span class="text-gray-11 group-hover:text-gray-12">Preferences</span>
                        </a>

                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-base md:text-sm font-medium text-center transition-all ease-in-out duration-200">
                            @icon('email', 'h-7 w-7 md:h-6 md:w-6 text-gray-9 group-hover:text-gray-10')
                            <span class="text-gray-11 group-hover:text-gray-12">Messages</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-3 text-red-11 border border-red-6">3</span>
                        </a>
                    </div>
                </x-panel>
            </section>

            <section class="hidden" aria-labelledby="dashboard-stats-title">
                <h2 class="sr-only" id="dashboard-stats-title">Dashboard Stats</h2>

                <div>
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <x-panel>
                            <x-content-box>
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('users', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Total Users</p>
                                </dt>
                                <dd class="ml-16 flex items-baseline">
                                    <p class="text-2xl font-semibold text-gray-12">
                                        14
                                    </p>
                                    <p class="ml-2 flex items-baseline">
                                        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-11 rounded-full bg-green-3 border border-green-6 pl-1 pr-2">
                                        <!-- Heroicon name: solid/arrow-sm-up -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-green-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">
                                            Increased by
                                        </span>
                                        2
                                    </p>
                                </dd>
                            </x-content-box>
                        </x-panel>

                        <x-panel>
                            <x-content-box>
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('book', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Story Posts</p>
                                </dt>
                                <dd class="ml-16 flex items-baseline">
                                    <p class="text-2xl font-semibold text-gray-12">
                                        52
                                    </p>
                                    <p class="ml-2 flex items-baseline">
                                        <p class="ml-2 flex items-baseline text-sm font-semibold text-red-11 rounded-full bg-red-3 border border-red-6 pl-1 pr-2">
                                        <!-- Heroicon name: solid/arrow-sm-up -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-red-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                        <span class="sr-only">
                                            Decreased by
                                        </span>
                                        12
                                    </p>
                                </dd>
                            </x-content-box>
                        </x-panel>

                        <x-panel>
                            <x-content-box>
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('write', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">In Progress Posts</p>
                                </dt>
                                <dd class="ml-16 flex items-baseline">
                                    <p class="text-2xl font-semibold text-gray-12">
                                        2
                                    </p>
                                </dd>
                            </x-content-box>
                        </x-panel>

                        {{-- <div class="relative bg-gray-1 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                    @icon('users', 'h-6 w-6 text-blue-9')
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-11 truncate">Total Subscribers</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-12">
                                    71,897
                                </p>
                                <p class="ml-2 flex items-baseline">
                                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-11 rounded-full bg-green-3 border border-green-6 pl-1 pr-2">
                                    <!-- Heroicon name: solid/arrow-sm-up -->
                                    <svg class="self-center shrink-0 h-5 w-5 text-green-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">
                                        Increased by
                                    </span>
                                    122
                                </p>
                            </dd>
                        </div>

                        <div class="relative bg-gray-1 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                    @icon('email', 'h-6 w-6 text-blue-9')
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-11 truncate">Avg. Open Rate</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-12">
                                    58.16%
                                </p>
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-11">
                                    <!-- Heroicon name: solid/arrow-sm-up -->
                                    <svg class="self-center shrink-0 h-5 w-5 text-green-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">
                                        Increased by
                                    </span>
                                    5.4%
                                </p>
                            </dd>
                        </div>

                        <div class="relative bg-gray-1 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                    @icon('warning', 'h-6 w-6 text-blue-9')
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-11 truncate">Avg. Click Rate</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-12">
                                    24.57%
                                </p>
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-red-11">
                                    <!-- Heroicon name: solid/arrow-sm-down -->
                                    <svg class="self-center shrink-0 h-5 w-5 text-red-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">
                                        Decreased by
                                    </span>
                                    3.2%
                                </p>
                            </dd>
                        </div> --}}
                    </dl>
                </div>

            </section>

            <section aria-labelledby="timeline-title">
                <div class="bg-gray-1 px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="timeline-title" class="text-lg font-medium text-gray-12">Recent Activity</h2>

                    <!-- Activity Feed -->
                    <div class="mt-6 flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-gray-3 border border-gray-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('user', 'h-6 w-6 text-gray-11')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">Character bio updated for <a href="#" class="font-medium text-gray-12">Stanley Maura</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-20">Sep 20</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-blue-3 border border-blue-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('book', 'h-6 w-6 text-blue-9')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">New story post by <a href="#" class="font-medium text-gray-12">Bethany Blake</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-22">Sep 22</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-green-3 border border-green-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('email', 'h-6 w-6 text-green-9')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">New message from <a href="#" class="font-medium text-gray-12">Martha Gardner</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-28">Sep 28</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    {{-- <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span> --}}
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-blue-3 border border-blue-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('location', 'h-6 w-6 text-blue-9')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">New story marker by <a href="#" class="font-medium text-gray-12">Bethany Blake</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-30">Sep 30</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch">
                        <x-link href="#">See all activity</x-link>
                    </div>
                </div>
            </section>

            <!-- Actions panel -->
            <section class="hidden" aria-labelledby="quick-links-title">
                <div class="rounded-lg bg-gray-1 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
                    <h2 class="sr-only" id="quick-links-title">Quick links</h2>

                    <div class="rounded-tl-lg relative group bg-gray-1 p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-blue-3 text-blue-9 border border-blue-6 ring-4 ring-gray-1">
                                @icon('write', 'h-6 w-6')
                            </span>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-xl font-medium text-gray-12">
                                <a href="{{ route('posts.create') }}" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    Write a new story post
                                </a>
                            </h3>
                        </div>
                        <span class="absolute top-6 right-6 text-gray-9 group-hover:text-gray-10" aria-hidden="true">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                            </svg>
                        </span>
                    </div>

                    <div class="rounded-tr-lg relative group bg-gray-1 p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-purple-3 text-purple-9 border border-purple-6 ring-4 ring-gray-1">
                                @icon('note', 'h-6 w-6')
                            </span>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-xl font-medium text-gray-12">
                                <a href="{{ route('notes.index') }}" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    My notes
                                </a>
                            </h3>
                        </div>
                        <span class="absolute top-6 right-6 text-gray-9 group-hover:text-gray-10" aria-hidden="true">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                            </svg>
                        </span>
                    </div>

                    <div class="rounded-bl-lg relative group bg-gray-1 p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-red-3 text-red-9 border border-red-6 ring-4 ring-gray-1">
                                @icon('preferences', 'h-6 w-6')
                            </span>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-xl font-medium text-gray-12">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    My preferences
                                </a>
                            </h3>
                        </div>
                        <span class="absolute top-6 right-6 text-gray-9 group-hover:text-gray-10" aria-hidden="true">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                            </svg>
                        </span>
                    </div>

                    <div class="rounded-br-lg relative group bg-gray-1 p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                        <div>
                            <span class="rounded-lg inline-flex p-3 bg-orange-3 text-orange-9 border border-orange-6 ring-4 ring-gray-1">
                                @icon('notification', 'h-6 w-6')
                            </span>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-xl font-medium text-gray-12">
                                <a href="#" class="focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    My notifications
                                </a>
                            </h3>
                        </div>
                        <span class="absolute top-6 right-6 text-gray-9 group-hover:text-gray-10" aria-hidden="true">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                            </svg>
                        </span>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right column -->
        <div class="grid grid-cols-1 gap-4">
            <section class="hidden" aria-labelledby="timeline-title">
                <div class="bg-gray-1 px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="timeline-title" class="text-lg font-medium text-gray-12">Recent Activity</h2>

                    <!-- Activity Feed -->
                    <div class="mt-6 flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-gray-3 border border-gray-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('user', 'h-6 w-6 text-gray-11')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">Character bio updated for <a href="#" class="font-medium text-gray-12">Stanley Maura</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-20">Sep 20</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-blue-3 border border-blue-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('book', 'h-6 w-6 text-blue-9')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">New story post by <a href="#" class="font-medium text-gray-12">Bethany Blake</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-22">Sep 22</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-green-3 border border-green-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('email', 'h-6 w-6 text-green-9')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">New message from <a href="#" class="font-medium text-gray-12">Martha Gardner</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-28">Sep 28</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    {{-- <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-6" aria-hidden="true"></span> --}}
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-blue-3 border border-blue-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('location', 'h-6 w-6 text-blue-9')
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-11">New story marker by <a href="#" class="font-medium text-gray-12">Bethany Blake</a></p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-11">
                                                <time datetime="2020-09-30">Sep 30</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch">
                        <x-link href="#">See all activity</x-link>
                    </div>
                </div>
            </section>

            <section aria-labelledby="dashboard-stats-title">
                <x-panel>
                    <x-content-box>
                        <h2 id="dashboard-stats-title" class="sr-only text-lg font-medium text-gray-12">Stats</h2>

                        <dl class="grid grid-cols-1 gap-6">
                            <div>
                                <dt>
                                    <div class="absolute bg-purple-3 border border-purple-6 rounded-md p-3">
                                        @icon('users', 'h-6 w-6 text-purple-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Total Users</p>
                                </dt>
                                <dd class="ml-16 flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-12">
                                        14
                                    </p>
                                    <p class="ml-2 flex items-baseline">
                                        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-11 rounded-full bg-green-3 border border-green-6 pl-1 pr-2">
                                        <!-- Heroicon name: solid/arrow-sm-up -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-green-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">
                                            Increased by
                                        </span>
                                        2
                                    </p>
                                </dd>
                            </div>

                            <div class="border-t border-gray-3 pt-6">
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('book', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Story Posts</p>
                                </dt>
                                <dd class="ml-16 flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-12">
                                        52
                                    </p>
                                    <p class="ml-2 flex items-baseline">
                                        <p class="ml-2 flex items-baseline text-sm font-semibold text-red-11 rounded-full bg-red-3 border border-red-6 pl-1 pr-2">
                                        <!-- Heroicon name: solid/arrow-sm-up -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-red-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                        <span class="sr-only">
                                            Decreased by
                                        </span>
                                        12
                                    </p>
                                </dd>
                            </div>

                            <div class="border-t border-gray-3 pt-6">
                                <dt>
                                    <div class="absolute bg-yellow-3 border border-yellow-6 rounded-md p-3">
                                        @icon('write', 'h-6 w-6 text-yellow-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">In Progress Posts</p>
                                </dt>
                                <dd class="ml-16 flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-12">
                                        2
                                    </p>
                                </dd>
                            </div>

                            {{-- <div class="relative bg-gray-1 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('users', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Total Subscribers</p>
                                </dt>
                                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                    <p class="text-2xl font-semibold text-gray-12">
                                        71,897
                                    </p>
                                    <p class="ml-2 flex items-baseline">
                                        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-11 rounded-full bg-green-3 border border-green-6 pl-1 pr-2">
                                        <!-- Heroicon name: solid/arrow-sm-up -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-green-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">
                                            Increased by
                                        </span>
                                        122
                                    </p>
                                </dd>
                            </div>

                            <div class="relative bg-gray-1 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('email', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Avg. Open Rate</p>
                                </dt>
                                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                    <p class="text-2xl font-semibold text-gray-12">
                                        58.16%
                                    </p>
                                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-11">
                                        <!-- Heroicon name: solid/arrow-sm-up -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-green-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">
                                            Increased by
                                        </span>
                                        5.4%
                                    </p>
                                </dd>
                            </div>

                            <div class="relative bg-gray-1 pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                                <dt>
                                    <div class="absolute bg-blue-3 border border-blue-6 rounded-md p-3">
                                        @icon('warning', 'h-6 w-6 text-blue-9')
                                    </div>
                                    <p class="ml-16 text-sm font-medium text-gray-11 truncate">Avg. Click Rate</p>
                                </dt>
                                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                    <p class="text-2xl font-semibold text-gray-12">
                                        24.57%
                                    </p>
                                    <p class="ml-2 flex items-baseline text-sm font-semibold text-red-11">
                                        <!-- Heroicon name: solid/arrow-sm-down -->
                                        <svg class="self-center shrink-0 h-5 w-5 text-red-9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">
                                            Decreased by
                                        </span>
                                        3.2%
                                    </p>
                                </dd>
                            </div> --}}
                        </dl>
                    </x-content-box>
                </x-panel>

            </section>
        </div>
    </div>
</div>

<x-tips section="dashboard" />
@endsection
