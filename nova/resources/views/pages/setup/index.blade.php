@extends('layouts.setup')

@section('content')
<div x-data="{ tab: 'intro', isLoading: false }">
    <div>
        <div class="p-4 | sm:hidden">
            <select x-on:change="tab = $event.target.value" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring focus:border-blue-7 sm:text-sm transition ease-in-out duration-150">
                <option value="intro" x-bind:selected="tab === 'intro'">Intro</option>
                <option value="install" x-bind:selected="tab === 'install'">Install</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200 px-4 | sm:px-6">
                <nav class="-mb-px flex">
                    <a
                        @click.prevent="tab = 'intro'"
                        href="#"
                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm focus:outline-none"
                        :class="{ 'border-blue-6 text-blue-9': tab === 'intro', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'intro' }"
                    >
                        Intro
                    </a>
                    <a
                        @click.prevent="tab = 'install'"
                        href="#"
                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm focus:outline-none"
                        :class="{ 'border-blue-6 text-blue-9': tab === 'install', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'install' }"
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

            <p class="mb-8">
                We've decided to provide Patrons with regular downloadable previews of the work being done on Nova 3. This is not intended to be used for QA purposes, but just to a way to get feedback from valued members of the community about the direction of Nova 3.
            </p>

            <p class="mb-8">
                Please do not share this with anyone outside of the Anodyne Patreon community. Any feedback regarding this preview can be sent in the <a href="https://discord.gg/7WmKUks" target="_blank" class="text-blue-9 hover:text-blue-10 transition ease-in-out duration-150 font-medium">#patrons</a> channel on Discord.
            </p>

            <div class="rounded-md bg-yellow-3 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @icon('warning', 'h-7 w-7 text-yellow-9')
                    </div>
                    <div class="ml-4 flex-1 | md:flex md:justify-between">
                        <p class="text-yellow-11 font-medium">
                            This is alpha-level software and is not suitable for a production environment!
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'install'" x-cloak>
            <h2 class="text-2xl font-light mb-8 text-center">Here we go!</h2>

            <x-form action="setup/install">
                <div class="flex items-center justify-center">
                    <x-button
                        x-on:click="isLoading = true"
                        type="submit"
                        color="blue"
                        size="lg"
                        class="relative disabled:cursor-not-allowed justify-center"
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
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
