@extends('layouts.setup')

@section('content')
<div x-data="{ tab: 'intro', isLoading: false }">
    <div>
        <div class="p-4 | sm:hidden">
            <select x-on:change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                <option value="#"{{ request()->status === 'active' ? 'selected' : '' }}>Active Users</option>
                <option value="#"{{ request()->status === 'pending' ? 'selected' : '' }}>Pending Users</option>
                <option value="#"{{ request()->status === 'inactive' ? 'selected' : '' }}>Inactive Users</option>
                <option value="#"{{ !request()->has('status') ? 'selected' : '' }}>All Users</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200 px-4 | sm:px-6">
                <nav class="-mb-px flex">
                    <a
                        @click.prevent="tab = 'intro'"
                        href="#"
                        class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm leading-5 focus:outline-none"
                        :class="{ 'border-blue-500 text-blue-600': tab === 'intro', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'intro' }"
                    >
                        Intro
                    </a>
                    <a
                        @click.prevent="tab = 'instructions'"
                        href="#"
                        class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm leading-5 focus:outline-none"
                        :class="{ 'border-blue-500 text-blue-600': tab === 'instructions', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'instructions' }"
                    >
                        Instructions
                    </a>
                    <a
                        @click.prevent="tab = 'install'"
                        href="#"
                        class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm leading-5 focus:outline-none"
                        :class="{ 'border-blue-500 text-blue-600': tab === 'install', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'install' }"
                    >
                        Install
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div class="py-8 px-4 | sm:px-10">
        <div x-show="tab === 'intro'">
            <h2 class="text-2xl font-light mb-8 text-center">Thank you for supporting Anodyne&rsquo;s work on Nova 3!</h2>

            <p class="mb-8 leading-7">
                We've decided to provide Patrons with regular downloadable previews of the work being done on Nova 3. This is not intended to be used for QA purposes, but just to a way to get feedback from valued members of the community about the direction of Nova 3.
            </p>

            <p class="mb-8 leading-7">
                Please do not share this with anyone outside of the Anodyne Patreon community. Any feedback regarding this preview can be sent in the <a href="https://discord.gg/7WmKUks" target="_blank" class="text-blue-600 hover:text-blue-500 transition ease-in-out duration-150 font-medium">#patrons</a> channel on Discord.
            </p>

            <div class="rounded-md bg-yellow-50 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @icon('warning', 'h-7 w-7 text-yellow-400')
                    </div>
                    <div class="ml-4 flex-1 | md:flex md:justify-between">
                        <p class="leading-6 text-yellow-700 font-medium">
                            This is alpha-level software and is not suitable for a production environment!
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'instructions'" x-cloak>
            <h2 class="text-2xl font-light mb-6">Requirements</h2>

            <ol class="list-disc pl-5 space-y-2">
                <li>PHP 7.3+</li>
                <li>MySQL 5.7+</li>
                <li>MySQL PDO installed for PHP</li>
                <li>Updated modern browser (Chrome 83+, Brave 1.9+, Safari 13+, Firefox 77+, or Edge 83+)</li>
            </ol>

            <h2 class="text-2xl font-light my-6">Instructions</h2>

            <ol class="list-decimal pl-5 space-y-2 mb-8">
                <li>Ensure you have a separate database for testing Nova 3.</li>
                <li>Copy the <code class="text-sm text-purple-600 font-medium">.env.example</code> file to a file called <code class="text-sm text-purple-600 font-medium">.env</code> in the root of the project.</li>
                <li>Update the database credentials in <code class="text-sm text-purple-600 font-medium">.env</code> indicated by the <code class="text-sm text-purple-600 font-medium">DB_</code> prefix.</li>
                <li>From the command line, run the following command: <code class="text-sm text-purple-600 font-medium">php artisan key:generate</code>.</li>
                <li>Click the Install button on the next step.</li>
            </ol>

            <div class="rounded-md bg-purple-50 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @icon('info', 'h-7 w-7 text-purple-400')
                    </div>
                    <div class="ml-4 flex-1 | md:flex md:justify-between">
                        <p class="leading-6 text-purple-700 font-medium">
                            This process must be completed each time a new preview version is released to Patrons. This will clear out the database and re-create the structure and data.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'install'" x-cloak>
            <form action="setup/install" method="POST">
                @csrf

                <h2 class="text-2xl font-light mb-8 text-center">Here we go!</h2>

                <div class="flex items-center justify-center">
                    <button
                        x-on:click="isLoading = true"
                        type="submit"
                        class="button button-primary button-lg relative disabled:cursor-not-allowed justify-center"
                        x-bind:disabled="isLoading"
                    >
                        <span x-bind:class="{ 'text-transparent': isLoading }">Install Nova 3</span>
                        <template x-if="isLoading">
                            <svg class="absolute block fill-current h-3 leading-none mx-auto" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" />
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite" />
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" />
                                </circle>
                            </svg>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
