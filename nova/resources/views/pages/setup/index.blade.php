@extends('layouts.setup')

@section('content')
    <div x-data="{ tab: 'intro', isLoading: false }">
        <div>
            <div class="p-4 sm:hidden">
                <select
                    @change="tab = $event.target.value"
                    aria-label="Selected tab"
                    class="form-select mt-1 block w-full border-gray-300 bg-white py-2 pl-3 pr-10 text-base transition duration-200 ease-in-out focus:border-primary-400 focus:outline-none focus:ring sm:text-sm"
                >
                    <option value="intro" :selected="tab === 'intro'">
                        Intro
                    </option>
                    <option value="install" :selected="tab === 'install'">
                        Install
                    </option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-300 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            x-on:click.prevent="tab = 'intro'"
                            href="#"
                            class="w-1/2 border-b-2 px-1 py-4 text-center text-sm font-medium focus:outline-none"
                            :class="{ 'border-primary-300 text-primary-500': tab === 'intro', 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300': tab !== 'intro' }"
                        >
                            Intro
                        </a>
                        <a
                            x-on:click.prevent="tab = 'install'"
                            href="#"
                            class="w-1/2 border-b-2 px-1 py-4 text-center text-sm font-medium focus:outline-none"
                            :class="{ 'border-primary-300 text-primary-500': tab === 'install', 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300': tab !== 'install' }"
                        >
                            Install
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="px-4 py-8 sm:px-10">
            <div x-show="tab === 'intro'">
                <h2 class="mb-8 text-center text-2xl font-extrabold">
                    Thank you for supporting Anodyne&rsquo;s continued work on
                    Nova 3!
                </h2>

                <p class="mb-8 text-gray-600">
                    One of the perks of being a Patreon supporter is
                    downloadable previews of the work being done on Nova 3. This
                    is not intended to be used for QA purposes, but just as a
                    way to get feedback from valued members of the community
                    about the direction of Nova 3.
                </p>

                <p class="mb-8 text-gray-600">
                    Please do not share this with anyone outside of the Anodyne
                    Patreon community. Any feedback regarding this preview can
                    be sent in the
                    <a
                        href="https://discord.gg/7WmKUks"
                        target="_blank"
                        class="font-medium text-primary-500 transition duration-200 ease-in-out hover:text-primary-600"
                    >
                        #patreon-lounge
                    </a>
                    channel on Discord.
                </p>

                <div
                    class="rounded-md border border-warning-300 bg-warning-50 p-4"
                >
                    <div class="flex">
                        <div class="shrink-0">
                            <x-icon
                                name="warning"
                                size="xl"
                                class="text-warning-500"
                            ></x-icon>
                        </div>
                        <div
                            class="ml-4 flex-1 text-warning-600 md:flex md:justify-between"
                        >
                            <p class="font-medium text-warning-600">
                                This is alpha-level software and is not suitable
                                for a production environment!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="tab === 'install'" x-cloak>
                <h2 class="mb-8 text-center text-2xl font-extrabold">
                    Here we go!
                </h2>

                <form action="setup/install" method="POST">
                    @csrf

                    <div class="flex items-center justify-center">
                        <button
                            x-on:click="isLoading = true"
                            type="submit"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-500 px-4 py-2 text-center text-base font-medium text-white transition duration-200 ease-in-out hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-75"
                        >
                            <span :class="{ 'text-transparent': isLoading }">
                                Install Nova 3
                            </span>
                            <template x-if="isLoading">
                                <svg
                                    class="absolute mx-auto block h-3 fill-current leading-none"
                                    viewBox="0 0 120 30"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="15" cy="15" r="15">
                                        <animate
                                            attributeName="r"
                                            from="15"
                                            to="15"
                                            begin="0s"
                                            dur="0.8s"
                                            values="15;9;15"
                                            calcMode="linear"
                                            repeatCount="indefinite"
                                        />
                                        <animate
                                            attributeName="fill-opacity"
                                            from="1"
                                            to="1"
                                            begin="0s"
                                            dur="0.8s"
                                            values="1;.5;1"
                                            calcMode="linear"
                                            repeatCount="indefinite"
                                        />
                                    </circle>
                                    <circle
                                        cx="60"
                                        cy="15"
                                        r="9"
                                        fill-opacity="0.3"
                                    >
                                        <animate
                                            attributeName="r"
                                            from="9"
                                            to="9"
                                            begin="0s"
                                            dur="0.8s"
                                            values="9;15;9"
                                            calcMode="linear"
                                            repeatCount="indefinite"
                                        />
                                        <animate
                                            attributeName="fill-opacity"
                                            from="0.5"
                                            to="0.5"
                                            begin="0s"
                                            dur="0.8s"
                                            values=".5;1;.5"
                                            calcMode="linear"
                                            repeatCount="indefinite"
                                        />
                                    </circle>
                                    <circle cx="105" cy="15" r="15">
                                        <animate
                                            attributeName="r"
                                            from="15"
                                            to="15"
                                            begin="0s"
                                            dur="0.8s"
                                            values="15;9;15"
                                            calcMode="linear"
                                            repeatCount="indefinite"
                                        />
                                        <animate
                                            attributeName="fill-opacity"
                                            from="1"
                                            to="1"
                                            begin="0s"
                                            dur="0.8s"
                                            values="1;.5;1"
                                            calcMode="linear"
                                            repeatCount="indefinite"
                                        />
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
