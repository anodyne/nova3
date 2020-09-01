@extends($__novaTemplate)

@section('content')
    <x-page-header title="Settings" />

    <x-under-construction feature="Settings">
        <li>Settings are not stored in the database yet</li>
        <li>Settings cannot be updated</li>
    </x-under-construction>

    <x-panel
        x-data="tabs()"
        x-on:popstate.window="switchTab($event.state.tab)"
        class="md:grid md:grid-cols-4 md:gap-4"
    >
        <div class="col-span-1">
            <nav class="block w-full">
                <div class="p-4 | sm:hidden">
                    <select x-on:change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm transition ease-in-out duration-150">
                        <option value="general" x-bind:selected="tab === 'general'">General</option>
                        <option value="email" x-bind:selected="tab === 'email'">Email</option>
                        <option value="characters" x-bind:selected="tab === 'characters'">Characters</option>
                        <option value="defaults" x-bind:selected="tab === 'defaults'">Defaults</option>
                        <option value="meta-tags" x-bind:selected="tab === 'meta-tags'">Meta Tags</option>
                        <option value="discord" x-bind:selected="tab === 'discord'">Discord</option>
                    </select>
                </div>
                <div class="hidden | sm:block sm:p-6 sm:pr-2 sm:space-y-1">
                    <a
                        x-on:click.prevent="switchTab('general')"
                        href="{{ route('settings.index', 'general') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded focus:outline-none transition ease-in-out duration-150"
                        x-bind:class="{ 'bg-blue-50 text-blue-600 hover:text-blue-600 focus:text-blue-600': tab == 'general', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:text-gray-700': tab != 'general' }"
                    >
                        <span class="truncate">General</span>
                    </a>
                    <a
                        x-on:click.prevent="switchTab('email')"
                        href="{{ route('settings.index', 'email') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded focus:outline-none transition ease-in-out duration-150"
                        x-bind:class="{ 'bg-blue-50 text-blue-600 hover:text-blue-600 focus:text-blue-600': tab == 'email', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:text-gray-700': tab != 'email' }"
                    >
                        <span class="truncate">Email</span>
                    </a>
                    <a
                        x-on:click.prevent="switchTab('characters')"
                        href="{{ route('settings.index', 'characters') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded focus:outline-none transition ease-in-out duration-150"
                        x-bind:class="{ 'bg-blue-50 text-blue-600 hover:text-blue-600 focus:text-blue-600': tab == 'characters', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:text-gray-700': tab != 'characters' }"
                    >
                        <span class="truncate">Characters</span>
                    </a>
                    <a
                        x-on:click.prevent="switchTab('defaults')"
                        href="{{ route('settings.index', 'defaults') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded focus:outline-none transition ease-in-out duration-150"
                        x-bind:class="{ 'bg-blue-50 text-blue-600 hover:text-blue-600 focus:text-blue-600': tab == 'defaults', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:text-gray-700': tab != 'defaults' }"
                    >
                        <span class="truncate">Defaults</span>
                    </a>
                    <a
                        x-on:click.prevent="switchTab('meta-tags')"
                        href="{{ route('settings.index', 'meta-tags') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded focus:outline-none transition ease-in-out duration-150"
                        x-bind:class="{ 'bg-blue-50 text-blue-600 hover:text-blue-600 focus:text-blue-600': tab == 'meta-tags', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:text-gray-700': tab != 'meta-tags' }"
                    >
                        <span class="truncate">Meta Tags</span>
                    </a>
                    <a
                        x-on:click.prevent="switchTab('discord')"
                        href="{{ route('settings.index', 'discord') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded focus:outline-none transition ease-in-out duration-150"
                        x-bind:class="{ 'bg-blue-50 text-blue-600 hover:text-blue-600 focus:text-blue-600': tab == 'discord', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:text-gray-700': tab != 'discord' }"
                    >
                        <span class="truncate">Discord</span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="col-span-3 | sm:border-l sm:border-gray-100">
            <div>
                <div x-show="tab === 'general'" x-cloak>
                    @include('pages.settings._general')
                </div>

                <div x-show="tab === 'email'" x-cloak>
                    @include('pages.settings._email')
                </div>

                <div x-show="tab === 'characters'" x-cloak>
                    @include('pages.settings._characters')
                </div>

                <div x-show="tab === 'defaults'" x-cloak>
                    @include('pages.settings._defaults')
                </div>

                <div x-show="tab === 'meta-tags'" x-cloak>
                    @include('pages.settings._meta-tags')
                </div>

                <div x-show="tab === 'discord'" x-cloak>
                    @include('pages.settings._discord')
                </div>
            </div>
        </div>
    </x-panel>

    <x-tips section="settings" />
@endsection

@push('scripts')
    <script>
        function tabs()
        {
            return {
                tab: '{{ $tab }}',

                switchTab (tab) {
                    this.tab = tab;
                    history.pushState({ tab: this.tab }, null, tab);
                }
            };
        }
    </script>
@endpush
