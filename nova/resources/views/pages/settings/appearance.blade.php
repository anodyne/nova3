@use('Nova\Settings\Enums\AvatarShape')
@use('Nova\Settings\Enums\AvatarStyle')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.settings.appearance.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="paint-brush"></x-icon>
                    <x-fieldset.legend>Theme</x-fieldset.legend>
                    <x-fieldset.description>
                        Update the way your public site looks through the theme and its settings.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <livewire:theme-selector />
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="image"></x-icon>
                    <x-fieldset.legend>Logo</x-fieldset.legend>
                    <x-fieldset.description>
                        You can upload a logo that will be used in the header of the admin system, in some themes for
                        the public-facing site, as well as on the sign in pages.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field id="logo" name="logo">
                        <livewire:media-upload-image
                            :model="settings()"
                            media-collection-name="logo"
                            support-message="PNG, JPG, or SVG (max. 5MB)"
                        />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="palette"></x-icon>
                    <x-fieldset.legend>Colors</x-fieldset.legend>
                    <x-fieldset.description>
                        Put your own personal touch on Nova by changing the colors used throughout the admin system. You
                        can choose from a series of pre-defined color scales or specify your own color and a color scale
                        will be created for you.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Gray" id="colors_gray" name="colors_gray">
                        <livewire:color-shade-picker type="gray" name="colors_gray" :selected="$settings->colorsGray" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Primary color" id="colors_primary" name="colors_primary">
                        <livewire:color-shade-picker
                            type="colors"
                            name="colors_primary"
                            :selected="$settings->colorsPrimary"
                            :allow-panda="true"
                        />
                    </x-fieldset.field>

                    <x-fieldset.field label="Danger color" id="colors_danger" name="colors_danger">
                        <livewire:color-shade-picker
                            type="colors"
                            name="colors_danger"
                            :selected="$settings->colorsDanger"
                        />
                    </x-fieldset.field>

                    <x-fieldset.field label="Warning color" id="colors_warning" name="colors_warning">
                        <livewire:color-shade-picker
                            type="colors"
                            name="colors_warning"
                            :selected="$settings->colorsWarning"
                        />
                    </x-fieldset.field>

                    <x-fieldset.field label="Success color" id="colors_success" name="colors_success">
                        <livewire:color-shade-picker
                            type="colors"
                            name="colors_success"
                            :selected="$settings->colorsSuccess"
                        />
                    </x-fieldset.field>

                    <x-fieldset.field label="Info color" id="colors_info" name="colors_info">
                        <livewire:color-shade-picker
                            type="colors"
                            name="colors_info"
                            :selected="$settings->colorsInfo"
                        />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="typography"></x-icon>
                    <x-fieldset.legend>Fonts</x-fieldset.legend>
                    <x-fieldset.description>
                        Customize Nova by changing the fonts used throughout the admin system.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Admin headers font" id="admin_font_header" name="admin_font_header">
                        <livewire:settings-font-selector
                            section="admin"
                            type="header"
                            :family="$settings->adminFonts->headerFamily"
                            :provider="$settings->adminFonts->headerProvider"
                        />
                    </x-fieldset.field>

                    <x-fieldset.field label="Admin body font" id="admin_font_body" name="admin_font_body">
                        <livewire:settings-font-selector
                            section="admin"
                            type="body"
                            :family="$settings->adminFonts->bodyFamily"
                            :provider="$settings->adminFonts->bodyProvider"
                        />
                    </x-fieldset.field>

                    {{--
                        <x-fieldset.field label="Public headers font" id="public_font_header" name="public_font_header">
                        <livewire:settings-font-selector section="public" type="header" />
                        </x-fieldset.field>
                        
                        <x-fieldset.field label="Public body font" id="public_font_body" name="public_font_body">
                        <livewire:settings-font-selector section="public" type="body" />
                        </x-fieldset.field>
                    --}}
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="user-profile"></x-icon>
                    <x-fieldset.legend>Avatars</x-fieldset.legend>
                    <x-fieldset.description>
                        Update the shape and style of avatars throughout Nova.

                        <x-fieldset.description class="mt-4">
                            <x-avatar :src="nova()->getAvatarUrl('nova3')" size="lg"></x-avatar>
                        </x-fieldset.description>
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Shape" id="avatar_shape" name="avatar_shape">
                        <x-select class="block w-full">
                            @foreach (AvatarShape::cases() as $shape)
                                <option value="{{ $shape->value }}" @selected($settings->avatarShape === $shape)>
                                    {{ $shape->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field label="Style" id="avatar_style" name="avatar_style">
                        <x-slot name="description">
                            Nova uses the
                            <x-button href="https://www.dicebear.com/" target="_blank" color="primary" text>
                                DiceBear avatar library
                            </x-button>
                            for generated avatars when a user or character has not had one uploaded.
                        </x-slot>

                        <x-select class="block w-full">
                            @foreach (AvatarStyle::cases() as $style)
                                <option value="{{ $style->value }}" @selected($settings->avatarStyle === $style)>
                                    {{ $style->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
