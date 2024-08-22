@extends($meta->template)

@use('Nova\Ranks\Models\RankGroup')
@use('Nova\Ranks\Models\RankName')

@section('content')
    <x-spacing
        x-data="{
            ...tabsList('base'),
            base: '{{ old('base_image', $item->base_image) }}',
            overlay: '{{ old('overlay_image', $item->overlay_image) }}'
        }"
        constrained
    >
        <x-page-header>
            <x-slot name="heading">Edit rank item</x-slot>

            <x-slot name="actions">
                @can('viewAny', $item::class)
                    <x-button :href="route('admin.ranks.items.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.ranks.items.update', $item)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field
                        label="Rank group"
                        id="group_id"
                        name="group_id"
                        :error="$errors->first('group_id')"
                    >
                        <div data-slot="control" class="flex w-full items-center">
                            <livewire:rank-groups-dropdown :group-id="old('group_id', $item->group_id)" />

                            @can('create', RankGroup::class)
                                <x-button :href="route('admin.ranks.groups.index')" color="neutral" class="ml-3" text>
                                    <x-icon name="settings" size="md"></x-icon>
                                </x-button>
                            @endcan
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field label="Rank name" id="name_id" name="name_id" :error="$errors->first('name_id')">
                        <div data-slot="control" class="flex w-full items-center">
                            <livewire:rank-names-dropdown :name-id="old('name_id', $item->name_id)" />

                            @can('create', RankName::class)
                                <x-button :href="route('admin.ranks.names.index')" color="neutral" class="ml-3" text>
                                    <x-icon name="settings" size="md"></x-icon>
                                </x-button>
                            @endcan
                        </div>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', $item->status->value ?? 'active')"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-fieldset.label for="status">Active</x-fieldset.label>
                    </div>

                    <x-fieldset.field
                        label="Rank preview"
                        id="rank_preview"
                        name="rank_preview"
                        :error="$errors->first('base_image')"
                    >
                        <div data-slot="control" x-show="overlay === '' && base === ''" class="h-10">
                            Make a selection below to see a live preview of your rank item
                        </div>

                        <div data-slot="control" class="rank" x-show="overlay !== '' || base !== ''">
                            <div class="rank-overlay" :style="`background-image: url(/ranks/overlay/${overlay})`"></div>
                            <div class="rank-base" :style="`background-image: url(/ranks/base/${base});`"></div>
                        </div>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="rank"></x-icon>
                    <x-fieldset.legend>Select your rank images</x-fieldset.legend>
                    <x-fieldset.description>
                        Ranks are comprised of a base image and an overlay image. This provides more flexibility with
                        creating ranks that precisely fit your game.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <div class="mt-8">
                    <x-tab.group name="images">
                        <x-tab.heading name="base">Base images</x-tab.heading>
                        <x-tab.heading name="overlay">Overlay images</x-tab.heading>
                    </x-tab.group>

                    <div class="mt-6 sm:h-96 sm:overflow-y-scroll">
                        <div x-show="isTab('base')">
                            <div class="mx-auto grid max-w-lg grid-cols-2 gap-4 lg:max-w-none lg:grid-cols-3">
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
                            <div class="mx-auto grid max-w-lg grid-cols-2 gap-4 lg:max-w-none lg:grid-cols-3">
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
                </div>

                <input type="hidden" name="base_image" x-model="base" />
                <input type="hidden" name="overlay_image" x-model="overlay" />
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('admin.ranks.items.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
