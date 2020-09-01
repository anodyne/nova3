@extends($__novaTemplate)

@section('content')
    <x-page-header title="Edit Rank Item">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.items.index') }}">Rank Items</a>
        </x-slot>
    </x-page-header>

    <x-panel x-data="{ tab: 'base', base: '{{ old('base_image', $item->base_image) }}', overlay: '{{ old('overlay_image', $item->overlay_image) }}' }">
        <x-form :action="route('ranks.items.update', $item)" method="PUT">
            <x-form.section title="Rank Info" message="You can build up your rank with a few clicks. Assign it to a group, set a name, and pick your base and overlay images to build your rank quickly and easily.">
                <x-input.group label="Rank Group" for="group_id" :error="$errors->first('group_id')">
                    <div class="flex items-center w-full">
                        @livewire('ranks:groups-dropdown', ['groupId' => old('group_id', $item->group_id)])

                        @can('create', 'Nova\Ranks\Models\RankGroup')
                            <a href="{{ route('ranks.groups.index') }}" class="ml-3 group inline-flex items-center text-gray-600 transition ease-in-out duration-150 hover:text-gray-500">
                                @icon('settings', 'h-6 w-6 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
                            </a>
                        @endcan
                    </div>
                </x-input.group>

                <x-input.group label="Rank Name" for="name_id" :error="$errors->first('name_id')">
                    <div class="flex items-center w-full">
                        @livewire('ranks:names-dropdown', ['nameId' => old('name_id', $item->name_id)])

                        @can('create', 'Nova\Ranks\Models\RankName')
                            <a href="{{ route('ranks.names.index') }}" class="ml-3 group inline-flex items-center text-gray-600 transition ease-in-out duration-150 hover:text-gray-500">
                                @icon('settings', 'h-6 w-6 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
                            </a>
                        @endcan
                    </div>
                </x-input.group>

                <x-input.group label="Rank Preview" :error="$errors->first('base_image')">
                    <div x-show="overlay === '' && base === ''">
                        Make a selection below to see a live preview of your rank item
                    </div>

                    <div class="rank" x-show="overlay !== '' || base !== ''">
                        <div class="rank-overlay" x-bind:style="`background-image: url(/ranks/overlay/${overlay})`"></div>
                        <div class="rank-base" x-bind:style="`background-image: url(/ranks/base/${base});`"></div>
                    </div>
                </x-input.group>
            </x-form.section>

            <div class="border-t border-gray-100 mt-10 px-4 pt-4 | sm:px-6 sm:pt-6">
                <div>
                    <div class="sm:hidden">
                        <select aria-label="Selected tab" class="form-select block w-full" x-on:change="tab = $event.target.value">
                            <option value="base">Base Images</option>
                            <option value="overlay">Overlay Images</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav class="flex">
                            <a
                                href="#"
                                x-on:click.prevent="tab = 'base'"
                                class="ml-4 first:ml-0 px-3 py-2 font-medium text-sm rounded-md  focus:outline-none"
                                x-bind:class="{ 'bg-primary-100 text-primary-700': tab === 'base', 'text-gray-500 hover:text-gray-700': tab !== 'base' }"
                            >
                                Base Images
                            </a>
                            <a
                                href="#"
                                x-on:click.prevent="tab = 'overlay'"
                                class="ml-4 first:ml-0 px-3 py-2 font-medium text-sm rounded-md  focus:outline-none"
                                x-bind:class="{ 'bg-primary-100 text-primary-700': tab === 'overlay', 'text-gray-500 hover:text-gray-700': tab !== 'overlay' }"
                            >
                                Overlay Images
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="mt-6 | sm:h-72 sm:overflow-y-scroll">
                    <div x-show="tab === 'base'">
                        <div class="grid gap-6 grid-cols-2 max-w-lg mx-auto | lg:grid-cols-4 lg:max-w-none">
                            @foreach ($baseImages as $baseImage)
                                <a
                                    x-on:click.prevent="base = '{{ $baseImage }}'"
                                    class="flex flex-col justify-center rounded-md border border-transparent py-2"
                                    x-bind:class="{ 'bg-blue-100 border-blue-200 hover:bg-blue-100 hover:border-blue-200': base === '{{ $baseImage }}', 'hover:bg-gray-100 hover:border-gray-200': base !== '{{ $baseImage }}' }"
                                    href="#"
                                >
                                    <img src="{{ asset('ranks/base/' . $baseImage) }}" alt="" class="block h-10 w-36 mx-auto">
                                    <span class="text-xs text-center text-gray-500">{{ $baseImage }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="tab === 'overlay'">
                        <div class="grid gap-6 grid-cols-2 max-w-lg mx-auto | lg:grid-cols-4 lg:max-w-none">
                            @foreach ($overlayImages as $overlayImage)
                                <a
                                    x-on:click.prevent="overlay = '{{ $overlayImage }}'"
                                    class="flex flex-col justify-center rounded-md border border-transparent py-2"
                                    x-bind:class="{ 'bg-blue-100 border-blue-200 hover:bg-blue-100 hover:border-blue-200': overlay === '{{ $overlayImage }}', 'hover:bg-gray-100 hover:border-gray-200': overlay !== '{{ $overlayImage }}' }"
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
                <x-button type="submit" color="blue">Update Rank Item</x-button>
                <x-button-link :href="route('ranks.items.index')" color="white">Cancel</x-button-link>
            </x-form.footer>

            <input type="hidden" name="base_image" x-model="base">
            <input type="hidden" name="overlay_image" x-model="overlay">
        </x-form>
    </x-panel>
@endsection
