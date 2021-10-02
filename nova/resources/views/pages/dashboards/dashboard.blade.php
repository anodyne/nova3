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
                        <div class="sm:flex sm:items-center sm:justify-between">
                            <div class="sm:flex sm:space-x-5">
                                <div class="flex-shrink-0">
                                    <img class="mx-auto h-20 w-20 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
                                </div>
                                <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                    <p class="text-sm font-medium text-gray-11">Welcome back,</p>
                                    <p class="text-xl font-medium text-gray-12 sm:text-2xl">Rebecca Nicholas</p>
                                </div>
                            </div>
                            <div class="mt-5 flex justify-center sm:mt-0">
                                <x-link href="#" size="xs">
                                    My account
                                </x-link>
                            </div>
                        </div>
                    </x-content-box>

                    <div class="sm:rounded-b-md border-t border-gray-6 bg-gray-2 grid grid-cols-1 divide-y divide-gray-6 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-sm font-medium text-center transition-all ease-in-out duration-150">
                            @icon('users', 'h-6 w-6 text-gray-9 group-hover:text-gray-10')
                            <span class="text-gray-11 group-hover:text-gray-12">Characters</span>
                        </a>

                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-sm font-medium text-center transition-all ease-in-out duration-150">
                            @icon('preferences', 'h-6 w-6 text-gray-9 group-hover:text-gray-10')
                            <span class="text-gray-11 group-hover:text-gray-12">Preferences</span>
                        </a>

                        <a href="#" class="group flex items-center justify-center space-x-3 px-6 py-5 text-sm font-medium text-center transition-all ease-in-out duration-150">
                            @icon('email', 'h-6 w-6 text-gray-9 group-hover:text-gray-10')
                            <span class="text-gray-11 group-hover:text-gray-12">Messages</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-3 text-red-11 border border-red-6">3</span>
                        </a>
                    </div>
                </x-panel>
            </section>

            <!-- Actions panel -->
            <section aria-labelledby="quick-links-title">
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
                                <a href="#" class="focus:outline-none">
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
                                <a href="#" class="focus:outline-none">
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
            <section aria-labelledby="timeline-title">
                <div class="bg-gray-1 px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="timeline-title" class="text-lg font-medium text-gray-12">Recent Activity</h2>

                    <!-- Activity Feed -->
                    <div class="mt-6 flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-1" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-gray-3 border border-gray-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('user', 'h-5 w-5 text-gray-11')
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
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-1" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-3 border border-blue-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('book', 'h-5 w-5 text-blue-11')
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
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-1" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-3 border border-green-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('email', 'h-5 w-5 text-green-11')
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
                                    {{-- <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-1" aria-hidden="true"></span> --}}
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-3 border border-blue-6 flex items-center justify-center ring-8 ring-gray-1">
                                                @icon('location', 'h-5 w-5 text-blue-11')
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
        </div>
    </div>
</div>

<x-tips section="dashboard" />
@endsection
