@use('Nova\Ranks\Models\RankGroup')
@use('Nova\Ranks\Models\RankName')

<x-admin-layout>
    <x-spacing
        x-data="{
            ...tabsList('base'),
            base: '{{ old('base_image', $item->base_image) }}',
            overlay: '{{ old('overlay_image', $item->overlay_image) }}'
        }"
        constrained
    >
        <x-page-header>
            @can('viewAny', $item::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.ranks.items.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.ranks.items.update', $item)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <flux:field>
                        <flux:label>Rank group</flux:label>
                        <livewire:rank-groups-dropdown :group="old('group_id', $item->group_id)" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Rank name</flux:label>
                        <livewire:rank-names-dropdown :name="old('name_id', $item->name_id)" />
                    </flux:field>

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
                        <div data-slot="control">
                            <div x-show="overlay === '' && base === ''" class="h-10">
                                Make a selection below to see a live preview of your rank item
                            </div>

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
                    <flux:tab.group>
                        <flux:tabs>
                            <flux:tab name="base">Base images</flux:tab>
                            <flux:tab name="overlay">Overlay images</flux:tab>
                        </flux:tabs>

                        <flux:tab.panel name="base">
                            <div
                                class="mx-auto grid max-w-lg grid-cols-2 gap-4 sm:h-96 sm:overflow-y-scroll lg:max-w-none lg:grid-cols-3"
                            >
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
                        </flux:tab.panel>

                        <flux:tab.panel name="overlay">
                            <div
                                class="mx-auto grid max-w-lg grid-cols-2 gap-4 sm:h-96 sm:overflow-y-scroll lg:max-w-none lg:grid-cols-3"
                            >
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
                        </flux:tab.panel>
                    </flux:tab.group>
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
</x-admin-layout>
