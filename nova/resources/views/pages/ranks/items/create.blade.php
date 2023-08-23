@extends($meta->template)

@section('content')
    <x-panel x-data="{ ...tabsList('base'), base: '{{ old('base_image') }}', overlay: '{{ old('overlay_image') }}' }">
        <x-panel.header title="Add a new rank item">
            <x-slot name="actions">
                @can('viewAny', Nova\Ranks\Models\RankItem::class)
                    <x-button.text :href="route('ranks.items.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('ranks.items.store')">
            <x-form.section
                title="Rank info"
                message="You can build up your rank with a few clicks. Assign it to a group, set a name, and pick your base and overlay images to build your rank quickly and easily."
            >
                <x-input.group label="Rank group" for="group_id" :error="$errors->first('group_id')">
                    <div class="flex w-full items-center">
                        <livewire:rank-groups-dropdown :group-id="old('group_id')" />

                        @can('create', 'Nova\Ranks\Models\RankGroup')
                            <x-button.text :href="route('ranks.groups.index')" color="gray" class="ml-3">
                                <x-icon name="settings" size="md"></x-icon>
                            </x-button.text>
                        @endcan
                    </div>
                </x-input.group>

                <x-input.group label="Rank name" for="name_id" :error="$errors->first('name_id')">
                    <div class="flex w-full items-center">
                        <livewire:rank-names-dropdown :name-id="old('name_id')" />

                        @can('create', 'Nova\Ranks\Models\RankName')
                            <x-button.text :href="route('ranks.names.index')" color="gray" class="ml-3">
                                <x-icon name="settings" size="md"></x-icon>
                            </x-button.text>
                        @endcan
                    </div>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="status"
                        :value="old('status', 'active')"
                        on-value="active"
                        off-value="inactive"
                    >
                        Active
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group label="Rank preview" :error="$errors->first('base_image')">
                    <div x-show="overlay === '' && base === ''" class="h-10">
                        Make a selection below to see a live preview of your rank item
                    </div>

                    <div class="rank" x-show="overlay !== '' || base !== ''">
                        <div class="rank-overlay" :style="`background-image: url(/ranks/overlay/${overlay})`"></div>
                        <div class="rank-base" :style="`background-image: url(/ranks/base/${base});`"></div>
                    </div>
                </x-input.group>
            </x-form.section>

            <x-content-box class="mt-10">
                <x-content-box height="none" width="none" class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="base">Base images</option>
                        <option value="overlay">Overlay images</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <nav class="flex">
                        <a
                            href="#"
                            x-on:click.prevent="switchTab('base')"
                            class="ml-4 rounded-md px-3 py-2 text-sm font-medium first:ml-0 focus:outline-none"
                            :class="{
                                'text-primary-600 dark:text-primary-400 bg-primary-100/75 dark:bg-primary-900/40': isTab('base'),
                                'hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100': isNotTab('base'),
                            }"
                        >
                            Base images
                        </a>
                        <a
                            href="#"
                            x-on:click.prevent="switchTab('overlay')"
                            class="ml-4 rounded-md px-3 py-2 text-sm font-medium first:ml-0 focus:outline-none"
                            :class="{
                                'text-primary-600 dark:text-primary-400 bg-primary-100/75 dark:bg-primary-900/40': isTab('overlay'),
                                'hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100': isNotTab('overlay'),
                            }"
                        >
                            Overlay images
                        </a>
                    </nav>
                </div>

                <div class="mt-6 sm:h-80 sm:overflow-y-scroll">
                    <div x-show="isTab('base')">
                        <div class="mx-auto grid max-w-lg grid-cols-2 gap-6 lg:max-w-none lg:grid-cols-4">
                            @foreach ($baseImages as $baseImage)
                                <a
                                    x-on:click.prevent="base = '{{ $baseImage }}'"
                                    class="flex flex-col justify-center rounded-md py-2 ring-1 ring-inset"
                                    :class="{
                                        'bg-primary-50 dark:bg-primary-400/10 text-primary-600 dark:text-primary-400 ring-primary-500/10 dark:ring-primary-400/20 font-medium': base === '{{ $baseImage }}',
                                        'ring-transparent hover:bg-gray-50 dark:hover:bg-gray-400/10 text-gray-600 dark:text-gray-400 hover:ring-gray-500/10 dark:hover:ring-gray-400/20': base !== '{{ $baseImage }}'
                                    }"
                                    href="#"
                                >
                                    <img
                                        src="{{ asset('ranks/base/'.$baseImage) }}"
                                        alt=""
                                        class="mx-auto block h-10 w-36"
                                    />
                                    <span class="text-center text-xs">{{ $baseImage }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="isTab('overlay')" x-cloak>
                        <div class="mx-auto grid max-w-lg grid-cols-2 gap-6 lg:max-w-none lg:grid-cols-4">
                            @foreach ($overlayImages as $overlayImage)
                                <a
                                    x-on:click.prevent="overlay = '{{ $overlayImage }}'"
                                    class="flex flex-col justify-center rounded-md py-2 ring-1 ring-inset"
                                    :class="{
                                        'bg-primary-50 dark:bg-primary-400/10 text-primary-600 dark:text-primary-400 ring-primary-500/10 dark:ring-primary-400/20 font-medium': overlay === '{{ $overlayImage }}',
                                        'ring-transparent hover:bg-gray-50 dark:hover:bg-gray-400/10 text-gray-600 dark:text-gray-400 hover:ring-gray-500/10 dark:hover:ring-gray-400/20': overlay !== '{{ $overlayImage }}'
                                    }"
                                    href="#"
                                >
                                    <img
                                        src="{{ asset('ranks/overlay/'.$overlayImage) }}"
                                        alt=""
                                        class="mx-auto block h-10 w-36"
                                    />
                                    <span class="text-center text-xs">{{ $overlayImage }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-content-box>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.filled :href="route('ranks.items.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>

            <input type="hidden" name="base_image" x-model="base" />
            <input type="hidden" name="overlay_image" x-model="overlay" />
        </x-form>
    </x-panel>
@endsection
