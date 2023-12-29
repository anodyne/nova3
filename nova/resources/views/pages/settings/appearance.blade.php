@extends($meta->template)

@inject('iconSets', 'Nova\Foundation\Icons\IconSets')

@section('content')
    <x-panel>
        <x-panel.header
            title="Appearance settings"
            message="Change the way Nova looks to match your game's design aesthetic"
        >
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" plain>
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.appearance.update')" method="PUT">
            <x-form.section title="Theme">
                <x-slot name="message">
                    <x-text>Update the way your site looks through the theme and icon set defaults.</x-text>
                </x-slot>

                <x-input.group label="Theme" for="theme">
                    <x-input.select class="mt-1 block w-full" id="theme" name="theme">
                        @foreach ($themes as $theme)
                            <option value="{{ $theme->location }}" @selected($theme->location === $settings->theme)>
                                {{ $theme->name }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Icon Set" for="icon_set">
                    <x-input.select class="mt-1 block w-full" id="icon_set" name="icon_set">
                        @foreach ($iconSets->getSets() as $alias => $set)
                            <option value="{{ $alias }}" @selected($alias === $settings->iconSet)>
                                {{ $set->name() }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Logo">
                <x-slot name="message">
                    <x-text>
                        You can upload a logo that will be used in the header of the admin system as well as on the sign
                        in pages.
                    </x-text>
                </x-slot>

                <x-input.group>
                    <livewire:media-upload-image
                        :model="settings()"
                        media-collection-name="logo"
                        support-message="PNG, JPG, or SVG (max. 5MB)"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Colors">
                <x-slot name="message">
                    <x-text>
                        Put your own personal touch on Nova by changing the colors used throughout the admin system. You
                        can choose from a series of pre-defined color scales or specify your own color and a color scale
                        will be created for you.
                    </x-text>
                </x-slot>

                <x-input.group label="Gray">
                    <livewire:color-shade-picker type="gray" name="colors_gray" :selected="$settings->colorsGray" />
                </x-input.group>

                <x-input.group label="Primary color">
                    <livewire:color-shade-picker
                        type="colors"
                        name="colors_primary"
                        :selected="$settings->colorsPrimary"
                        :allow-panda="true"
                    />
                </x-input.group>

                <x-input.group label="Danger color">
                    <livewire:color-shade-picker
                        type="colors"
                        name="colors_danger"
                        :selected="$settings->colorsDanger"
                    />
                </x-input.group>

                <x-input.group label="Warning color">
                    <livewire:color-shade-picker
                        type="colors"
                        name="colors_warning"
                        :selected="$settings->colorsWarning"
                    />
                </x-input.group>

                <x-input.group label="Success color">
                    <livewire:color-shade-picker
                        type="colors"
                        name="colors_success"
                        :selected="$settings->colorsSuccess"
                    />
                </x-input.group>

                <x-input.group label="Info color">
                    <livewire:color-shade-picker type="colors" name="colors_info" :selected="$settings->colorsInfo" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Font family">
                <x-slot name="message">
                    <x-text>Customize Nova by changing the font used throughout the admin system.</x-text>
                </x-slot>

                <livewire:settings-font-selector />
            </x-form.section>

            <x-form.section title="Avatars">
                <x-slot name="message">
                    <x-text>Update the shape and style of avatars throughout Nova.</x-text>

                    <x-avatar
                        src="https://api.dicebear.com/7.x/{{ $settings->avatarStyle }}/svg?seed=nova3"
                        size="lg"
                    ></x-avatar>
                </x-slot>

                <x-input.group label="Shape" for="avatar_shape">
                    <x-input.select class="block w-full" id="avatar_shape" name="avatar_shape">
                        <option value="circle" @selected($settings->avatarShape === 'circle')>Circle</option>
                        <option value="square" @selected($settings->avatarShape === 'square')>Square</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Style" for="avatar_style">
                    <x-slot name="help">
                        Nova uses the
                        <x-button href="https://www.dicebear.com/" target="_blank" color="primary" text>
                            DiceBear avatar library
                        </x-button>
                        for generated avatars when a user or character has not had one uploaded.
                    </x-slot>

                    <x-input.select class="block w-full" id="avatar_style" name="avatar_style">
                        @foreach ($settings->getAvatarStyles() as $value => $name)
                            <option value="{{ $value }}" @selected($settings->avatarStyle === $value)>
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
