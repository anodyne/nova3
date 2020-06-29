@extends($__novaTemplate)

@section('content')
    <x-page-header title="Settings" />

    <x-under-construction feature="Settings">
        <li>Settings are not stored in the database yet</li>
        <li>Settings cannot be updated</li>
    </x-under-construction>

    <x-panel x-data="tabs()" x-on:popstate.window="switchTab($event.state.tab)">
        <div>
            <div class="p-4 | sm:hidden">
                <select x-on:change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                    <option value="general" x-bind:selected="tab === 'general'">General</option>
                    <option value="email" x-bind:selected="tab === 'email'">Email</option>
                    <option value="defaults" x-bind:selected="tab === 'defaults'">Defaults</option>
                    <option value="meta-tags" x-bind:selected="tab === 'meta-tags'">Meta Tags</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            x-on:click.prevent="switchTab('general')"
                            href="{{ route('settings.index', 'general') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'general', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'general' }"
                        >
                            General
                        </a>
                        <a
                            x-on:click.prevent="switchTab('email')"
                            href="{{ route('settings.index', 'email') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'email', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'email' }"
                        >
                            Email
                        </a>
                        <a
                            x-on:click.prevent="switchTab('defaults')"
                            href="{{ route('settings.index', 'defaults') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'defaults', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'defaults' }"
                        >
                            Defaults
                        </a>
                        <a
                            x-on:click.prevent="switchTab('meta-tags')"
                            href="{{ route('settings.index', 'meta-tags') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'meta-tags', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'meta-tags' }"
                        >
                            Meta Tags
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div>
            <div x-show="tab === 'general'" x-cloak>
                @include('pages.settings._general')
            </div>

            <div x-show="tab === 'email'" x-cloak>
                @include('pages.settings._email')
            </div>

            <div x-show="tab === 'defaults'" x-cloak>
                @include('pages.settings._defaults')
            </div>

            <div x-show="tab === 'meta-tags'" x-cloak>
                @include('pages.settings._meta-tags')
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
