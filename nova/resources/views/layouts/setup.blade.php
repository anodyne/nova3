@extends('app')

@section('layout')
    <div class="relative flex min-h-screen flex-col bg-gray-100">
        <aside class="fixed inset-y-0 z-10 flex w-80 flex-col justify-between py-6">
            <div class="flex flex-col gap-16">
                <div class="flex shrink-0 items-center px-6">
                    <x-logos.nova class="block h-10 w-auto" />
                </div>

                <div class="flex flex-col gap-8 divide-y divide-gray-950/5">
                    <nav class="flex flex-col gap-2 px-3">
                        <a
                            href="{{ url('setup') }}"
                            @class([
                                'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup'),
                                'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup'),
                            ])
                        >
                            <x-icon name="tabler-server-2" size="md" class="mr-2.5 opacity-70"></x-icon>
                            <span>Can I run Nova?</span>
                        </a>
                        <a
                            href="{{ url('setup/configure-database') }}"
                            @class([
                                'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/configure-database'),
                                'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/configure-database'),
                            ])
                        >
                            <x-icon name="tabler-database-cog" size="md" class="mr-2.5 opacity-70"></x-icon>
                            <span>Connect to your database</span>
                        </a>
                        <a
                            href="{{ url('setup/install') }}"
                            @class([
                                'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/install'),
                                'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/install'),
                            ])
                        >
                            <x-icon name="tabler-sparkles" size="md" class="mr-2.5 opacity-70"></x-icon>
                            <span>Install Nova</span>
                        </a>
                        <a
                            href="{{ url('setup/migrate') }}"
                            @class([
                                'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/migrate*'),
                                'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/migrate*'),
                            ])
                        >
                            <x-icon name="tabler-database-import" size="md" class="mr-2.5 opacity-70"></x-icon>
                            <span>Migrate from Nova 2</span>
                        </a>
                        <a
                            href="{{ url('setup/user-account') }}"
                            @class([
                                'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/user-account'),
                                'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/user-account'),
                            ])
                        >
                            <x-icon name="tabler-user-circle" size="md" class="mr-2.5 opacity-70"></x-icon>
                            <span>Setup your account</span>
                        </a>
                    </nav>

                    <section class="hidden px-6 pt-8">
                        <h4 class="text-xs/6 font-medium text-gray-500">Progress</h4>

                        <ol role="list" class="mt-4 space-y-6">
                            <li>
                                <!-- Complete Step -->
                                <a href="#" class="group">
                                    <span class="flex items-start">
                                        <span class="relative flex h-5 w-5 flex-shrink-0 items-center justify-center">
                                            <svg
                                                class="h-full w-full text-primary-600 group-hover:text-primary-800"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </span>
                                        <span class="ml-3 text-sm font-medium text-gray-500 group-hover:text-gray-900">
                                            Configure database
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <!-- Current Step -->
                                <a href="#" class="flex items-start" aria-current="step">
                                    <span
                                        class="relative flex h-5 w-5 flex-shrink-0 items-center justify-center"
                                        aria-hidden="true"
                                    >
                                        <span class="absolute h-4 w-4 rounded-full bg-primary-200"></span>
                                        <span class="relative block h-2 w-2 rounded-full bg-primary-600"></span>
                                    </span>
                                    <span class="ml-3 text-sm font-medium text-primary-600">Install Nova</span>
                                </a>
                            </li>
                            <li>
                                <!-- Upcoming Step -->
                                <a href="#" class="group">
                                    <div class="flex items-start">
                                        <div
                                            class="relative flex h-5 w-5 flex-shrink-0 items-center justify-center"
                                            aria-hidden="true"
                                        >
                                            <div class="h-2 w-2 rounded-full bg-gray-300 group-hover:bg-gray-400"></div>
                                        </div>
                                        <p class="ml-3 text-sm font-medium text-gray-500 group-hover:text-gray-900">
                                            Install genre
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <!-- Upcoming Step -->
                                <a href="#" class="group">
                                    <div class="flex items-start">
                                        <div
                                            class="relative flex h-5 w-5 flex-shrink-0 items-center justify-center"
                                            aria-hidden="true"
                                        >
                                            <div class="h-2 w-2 rounded-full bg-gray-300 group-hover:bg-gray-400"></div>
                                        </div>
                                        <p class="ml-3 text-sm font-medium text-gray-500 group-hover:text-gray-900">
                                            Create user & character
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </ol>
                    </section>
                </div>
            </div>

            <div class="px-6">
                <div class="flex flex-col gap-4">
                    <x-icon name="tabler-lifebuoy" size="lg" class="text-gray-400"></x-icon>
                    <h4 class="text-sm font-medium text-gray-900">Need help?</h4>
                    <p class="text-sm/6 text-gray-600">
                        Check out the install guide or join the Discord server to get help with setting up Nova.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <x-button.filled color="neutral">Install guide</x-button.filled>
                        <x-button.filled color="neutral">Join Discord</x-button.filled>
                    </div>
                </div>
            </div>
        </aside>

        <main class="ml-80 mt-3 flex-1 rounded-tl-lg bg-white ring-1 ring-gray-950/5 focus:outline-none" tabindex="0">
            <div class="px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
@endsection
