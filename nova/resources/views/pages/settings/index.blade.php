@extends($__novaTemplate)

@section('content')
    <x-page-header title="Settings" />

    <x-panel x-data="{ tab: 'general' }">
        <div>
            <div class="p-4 | sm:hidden">
                <select x-on:change="tab = $event.target.value" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                    <option value="general" x-bind:selected="tab == 'general'">General</option>
                    <option value="email" x-bind:selected="tab == 'email'">Email</option>
                    <option value="defaults" x-bind:selected="tab == 'defaults'">Defaults</option>
                    <option value="meta-tags" x-bind:selected="tab == 'meta-tags'">Meta Tags</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            x-on:click.prevent="tab = 'general'"
                            href="#general"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600 focus:text-blue-800 focus:border-blue-700': tab == 'general', 'text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab != 'general' }"
                        >
                            General
                        </a>
                        <a
                            x-on:click.prevent="tab = 'email'"
                            href="#email"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600 focus:text-blue-800 focus:border-blue-700': tab == 'email', 'text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab != 'email' }"
                        >
                            Email
                        </a>
                        <a
                            x-on:click.prevent="tab = 'defaults'"
                            href="#defaults"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600 focus:text-blue-800 focus:border-blue-700': tab == 'defaults', 'text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab != 'defaults' }"
                        >
                            Defaults
                        </a>
                        <a
                            x-on:click.prevent="tab = 'meta-tags'"
                            href="#meta-tags"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600 focus:text-blue-800 focus:border-blue-700': tab == 'meta-tags', 'text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': tab != 'meta-tags' }"
                        >
                            Meta Tags
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="px-4 py-4 | sm:px-6 sm:py-6">
            <div x-show="tab == 'general'">
                General settings
            </div>

            <div x-show="tab == 'email'">
                Email settings
            </div>

            <div x-show="tab == 'defaults'">
                <x-input.group label="Theme" for="theme" class="sm:w-1/3">
                    <select class="form-select mt-1 block w-full" id="theme" name="theme">
                        <option value="pulsar" selected>Pulsar</option>
                        <option value="titan">Titan</option>
                    </select>
                </x-input.group>
            </div>

            <div x-show="tab == 'meta-tags'">
                Meta tags
            </div>
        </div>
    </x-panel>
@endsection
