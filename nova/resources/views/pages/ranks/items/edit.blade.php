@extends($meta->template)

@section('content')
    <x-panel x-data="{ tab: 'base', base: '{{ old('base_image', $item->base_image) }}', overlay: '{{ old('overlay_image', $item->overlay_image) }}' }">
        <x-panel.header title="Edit rank item">
            <x-slot:actions>
                @can('viewAny', Nova\Ranks\Models\RankItem::class)
                    <x-link :href="route('ranks.items.index')" leading="arrow-left" size="none" color="gray-text">
                        Back
                    </x-link>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('ranks.items.update', $item)" method="PUT">
            <x-form.section title="Rank Info" message="You can build up your rank with a few clicks. Assign it to a group, set a name, and pick your base and overlay images to build your rank quickly and easily.">
                <x-input.group label="Rank Group" for="group_id" :error="$errors->first('group_id')">
                    <div class="flex items-center w-full">
                        @livewire('ranks:groups-dropdown', ['groupId' => old('group_id', $item->group_id)])

                        @can('create', 'Nova\Ranks\Models\RankGroup')
                            <x-link :href="route('ranks.groups.index')" color="gray-text" size="none" class="ml-3">
                                @icon('settings', 'h-6 w-6')
                            </x-link>
                        @endcan
                    </div>
                </x-input.group>

                <x-input.group label="Rank Name" for="name_id" :error="$errors->first('name_id')">
                    <div class="flex items-center w-full">
                        @livewire('ranks:names-dropdown', ['nameId' => old('name_id', $item->name_id)])

                        @can('create', 'Nova\Ranks\Models\RankName')
                            <x-link :href="route('ranks.names.index')" color="gray-text" size="none" class="ml-3">
                                @icon('settings', 'h-6 w-6')
                            </x-link>
                        @endcan
                    </div>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="status"
                        :value="old('status', $item->status ?? 'active')"
                        active-value="active"
                        inactive-value="inactive"
                    >
                        Active
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Rank Preview" :error="$errors->first('base_image')">
                    <div x-show="overlay === '' && base === ''">
                        Make a selection below to see a live preview of your rank item
                    </div>

                    <div class="rank" x-show="overlay !== '' || base !== ''">
                        <div class="rank-overlay" :style="`background-image: url(/ranks/overlay/${overlay})`"></div>
                        <div class="rank-base" :style="`background-image: url(/ranks/base/${base});`"></div>
                    </div>
                </x-input.group>
            </x-form.section>

            <div class="border-t border-gray-100 mt-10 px-4 pt-4 sm:px-6 sm:pt-6">
                <div>
                    <div class="sm:hidden">
                        <select aria-label="Selected tab" class="form-select bg-white block w-full" @change="tab = $event.target.value">
                            <option value="base">Base Images</option>
                            <option value="overlay">Overlay Images</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav class="flex">
                            <a
                                href="#"
                                @click.prevent="tab = 'base'"
                                class="ml-4 first:ml-0 px-3 py-2 font-medium text-sm rounded-md  focus:outline-none"
                                :class="{ 'text-primary-600 dark:text-primary-400 bg-primary-100/75 dark:bg-primary-900/40': tab === 'base', 'hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100': tab !== 'base' }"
                            >
                                Base Images
                            </a>
                            <a
                                href="#"
                                @click.prevent="tab = 'overlay'"
                                class="ml-4 first:ml-0 px-3 py-2 font-medium text-sm rounded-md  focus:outline-none"
                                :class="{ 'text-primary-600 dark:text-primary-400 bg-primary-100/75 dark:bg-primary-900/40': tab === 'overlay', 'hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100': tab !== 'overlay' }"
                            >
                                Overlay Images
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="mt-6 sm:h-72 sm:overflow-y-scroll">
                    <div x-show="tab === 'base'">
                        <div class="grid gap-6 grid-cols-2 max-w-lg mx-auto lg:grid-cols-4 lg:max-w-none">
                            @foreach ($baseImages as $baseImage)
                                <a
                                    @click.prevent="base = '{{ $baseImage }}'"
                                    class="flex flex-col justify-center rounded-md border border-transparent py-2"
                                    :class="{ 'bg-primary-50 border-primary-300': base === '{{ $baseImage }}', 'hover:bg-gray-50 hover:border-gray-300': base !== '{{ $baseImage }}' }"
                                    href="#"
                                >
                                    <img src="{{ asset('ranks/base/' . $baseImage) }}" alt="" class="block h-10 w-36 mx-auto">
                                    <span class="text-xs text-center text-gray-500">{{ $baseImage }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="tab === 'overlay'">
                        <div class="grid gap-6 grid-cols-2 max-w-lg mx-auto lg:grid-cols-4 lg:max-w-none">
                            @foreach ($overlayImages as $overlayImage)
                                <a
                                    @click.prevent="overlay = '{{ $overlayImage }}'"
                                    class="flex flex-col justify-center rounded-md border border-transparent py-2"
                                    :class="{ 'bg-primary-50 border-primary-300': overlay === '{{ $overlayImage }}', 'hover:bg-gray-50 hover:border-gray-300': overlay !== '{{ $overlayImage }}' }"
                                    href="#"
                                >
                                    <img src="{{ asset('ranks/overlay/' . $overlayImage) }}" alt="" class="block h-10 w-36 mx-auto">
                                    <span class="text-xs text-center text-gray-500">{{ $overlayImage }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-link :href="route('ranks.items.index')" color="white">Cancel</x-link>
            </x-form.footer>

            <input type="hidden" name="base_image" x-model="base">
            <input type="hidden" name="overlay_image" x-model="overlay">
        </x-form>
    </x-panel>
@endsection
