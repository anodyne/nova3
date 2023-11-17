<x-panel class="overflow-hidden" x-data="{ active: 'more' }">
    <x-panel.header
        title="What’s new in Nova 3?"
        message="Discover Nova 3’s new features and changes from Nova 2"
    ></x-panel.header>

    <div class="flex flex-col divide-gray-200 lg:flex-row lg:divide-x">
        <div class="flex flex-1 flex-col gap-6 divide-y divide-gray-200">
            <x-content-box>
                <div x-show="active === 'characters'" x-cloak>
                    @include('pages.dashboards.whats-new.characters')
                </div>

                <div x-show="active === 'users'" x-cloak>
                    @include('pages.dashboards.whats-new.users')
                </div>

                <div x-show="active === 'stories'" x-cloak>
                    @include('pages.dashboards.whats-new.stories')
                </div>

                <div x-show="active === 'ranks'" x-cloak>
                    @include('pages.dashboards.whats-new.ranks')
                </div>

                <div x-show="active === 'mobile'" x-cloak>
                    @include('pages.dashboards.whats-new.mobile')
                </div>

                <div x-show="active === 'more'" x-cloak>
                    @include('pages.dashboards.whats-new.more')
                </div>
            </x-content-box>
        </div>

        <div class="w-full lg:w-[22rem]">
            <div class="flex w-full flex-col gap-3 px-3 py-3">
                <button
                    type="button"
                    x-on:click="active = 'characters'"
                    class="relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition"
                    x-bind:class="{
                        'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900':
                            active !== 'characters',
                        'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20':
                            active === 'characters',
                    }"
                >
                    <x-icon name="tabler-masks-theater" size="md" class="mr-2.5 opacity-70"></x-icon>
                    <span>Characters</span>
                </button>
                <button
                    type="button"
                    x-on:click="active = 'users'"
                    class="relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition"
                    x-bind:class="{
                        'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900':
                            active !== 'users',
                        'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20':
                            active === 'users',
                    }"
                >
                    <x-icon name="tabler-users" size="md" class="mr-2.5 opacity-70"></x-icon>
                    <span>Users</span>
                </button>
                <button
                    type="button"
                    x-on:click="active = 'stories'"
                    class="relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition"
                    x-bind:class="{
                        'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900':
                            active !== 'stories',
                        'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20':
                            active === 'stories',
                    }"
                >
                    <x-icon name="tabler-books" size="md" class="mr-2.5 opacity-70"></x-icon>
                    <span>Storytelling</span>
                </button>
                <button
                    type="button"
                    x-on:click="active = 'ranks'"
                    class="relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition"
                    x-bind:class="{
                        'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900':
                            active !== 'ranks',
                        'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20':
                            active === 'ranks',
                    }"
                >
                    <x-icon name="tabler-military-rank" size="md" class="mr-2.5 opacity-70"></x-icon>
                    <span>Ranks</span>
                </button>
                <button
                    type="button"
                    x-on:click="active = 'mobile'"
                    class="relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition"
                    x-bind:class="{
                        'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900':
                            active !== 'mobile',
                        'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20':
                            active === 'mobile',
                    }"
                >
                    <x-icon name="tabler-devices" size="md" class="mr-2.5 opacity-70"></x-icon>
                    <span>Mobile</span>
                </button>
                <button
                    type="button"
                    x-on:click="active = 'more'"
                    class="relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition"
                    x-bind:class="{
                        'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900': active !== 'more',
                        'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20':
                            active === 'more',
                    }"
                >
                    <x-icon name="tabler-adjustments" size="md" class="mr-2.5 opacity-70"></x-icon>
                    <span>And much more...</span>
                </button>
            </div>
        </div>
    </div>
</x-panel>
