@use('Nova\Foundation\Enums\BasicStatus')
@use('Nova\Ranks\Models\RankGroup')
@use('Nova\Ranks\Models\RankName')

<x-admin-layout>
    <x-spacing
        x-data="{
            base: {{ Js::from(old('base_image', $item->base_image)) }},
            overlay: {{ Js::from(old('overlay_image', $item->overlay_image)) }}
        }"
        constrained
    >
        <x-page-header>
            @can('viewAny', $item::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.ranks.items.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.ranks.items.update', $item)" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input.field>
                        <x-label>Rank group</x-label>
                        <livewire:rank-groups-dropdown :group="old('group_id', $item->group_id)" />
                    </x-input.field>

                    <x-input.field>
                        <x-label>Rank name</x-label>
                        <livewire:rank-names-dropdown :name="old('name_id', $item->name_id)" />
                    </x-input.field>

                    <x-switch
                        label="Active"
                        name="status"
                        :checked="old('status', $item->status === BasicStatus::Active)"
                        align="left"
                    />

                    <x-input.field>
                        <x-label>Rank preview</x-label>

                        <x-text x-show="overlay === '' && base === ''" class="h-10">
                            Make a selection below to see a live preview of your rank item
                        </x-text>

                        <div
                            class="nv-rank-ctn grid h-10 w-36 shrink-0 overflow-hidden [grid-template-areas:'rank']"
                            x-show="overlay !== '' || base !== ''"
                        >
                            <div
                                class="nv-rank-overlay-img h-10 w-36 bg-transparent [background-size:144px_40px] [grid-area:rank]"
                                x-bind:style="`background-image:url(/ranks/base/${base})`"
                            ></div>
                            <div
                                class="nv-rank-base-img h-10 w-36 bg-transparent [background-size:144px_40px] [grid-area:rank]"
                                x-bind:style="`background-image:url(/ranks/overlay/${overlay})`"
                            ></div>
                        </div>
                    </x-input.field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::MilitaryRank" heading="Select your rank images">
                    <x-description>
                        Ranks are comprised of a base image and an overlay image. This provides more flexibility with
                        creating ranks that precisely fit your game.
                    </x-description>
                </x-fieldset.heading>

                <div class="mt-8">
                    <x-tab.group>
                        <x-slot name="tabs">
                            <x-tab name="base">Base images</x-tab>
                            <x-tab name="overlay">Overlay images</x-tab>
                        </x-slot>

                        <x-tab.panel name="base">
                            <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
                                @foreach ($baseImages as $baseImage)
                                    <label
                                        for="base_{{ $baseImage }}"
                                        class="has-checked:bg-primary-50 has-checked:text-primary-700 has-checked:ring-primary-200 dark:has-checked:bg-primary-950 dark:has-checked:text-primary-300 dark:has-checked:ring-primary-800 flex flex-col justify-center rounded-lg py-2 text-gray-600 ring-1 ring-transparent ring-inset hover:bg-gray-50 hover:ring-gray-200 has-checked:font-medium dark:text-gray-400 dark:hover:bg-gray-950 dark:hover:text-gray-300 dark:hover:ring-gray-800"
                                    >
                                        <input
                                            type="radio"
                                            name="base_image"
                                            id="base_{{ $baseImage }}"
                                            value="{{ $baseImage }}"
                                            x-model="base"
                                            class="hidden"
                                        />

                                        <img
                                            src="{{ asset('ranks/base/'.$baseImage) }}"
                                            alt=""
                                            class="mx-auto block h-10 w-36"
                                        />

                                        <span class="text-center text-xs">{{ $baseImage }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </x-tab.panel>

                        <x-tab.panel name="overlay">
                            <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
                                @foreach ($overlayImages as $overlayImage)
                                    <label
                                        for="overlay_{{ $overlayImage }}"
                                        class="has-checked:bg-primary-50 has-checked:text-primary-700 has-checked:ring-primary-200 dark:has-checked:bg-primary-950 dark:has-checked:text-primary-300 dark:has-checked:ring-primary-800 flex flex-col justify-center rounded-lg py-2 text-gray-600 ring-1 ring-transparent ring-inset hover:bg-gray-50 hover:ring-gray-200 has-checked:font-medium dark:text-gray-400 dark:hover:bg-gray-950 dark:hover:text-gray-300 dark:hover:ring-gray-800"
                                    >
                                        <input
                                            type="radio"
                                            name="overlay_image"
                                            id="overlay_{{ $overlayImage }}"
                                            value="{{ $overlayImage }}"
                                            x-model="overlay"
                                            class="hidden"
                                        />

                                        <img
                                            src="{{ asset('ranks/overlay/'.$overlayImage) }}"
                                            alt=""
                                            class="mx-auto block h-10 w-36"
                                        />

                                        <p class="text-center text-xs">{{ $overlayImage }}</p>
                                    </label>
                                @endforeach
                            </div>
                        </x-tab.panel>
                    </x-tab.group>
                </div>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.ranks.items.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
