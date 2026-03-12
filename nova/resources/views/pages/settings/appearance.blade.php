@use('Nova\Settings\Enums\AvatarShape')
@use('Nova\Settings\Enums\AvatarStyle')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button.find-setting />
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.settings.appearance.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Brush" heading="Public site theme">
                    <x-description>
                        Update the way your public site looks through the theme and its settings.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <livewire:theme-selector />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Photo" heading="Logos">
                    <x-description>
                        You can upload logos that will be used on the login page and in the sidebar of the admin panel.
                        Additionally, themes for the public-facing site will be able to use any of these logos as well.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-field>
                        <x-label>Full logo</x-label>

                        <livewire:media-upload-image
                            :model="settings()"
                            media-collection-name="logo-full"
                            support-message="PNG, JPG, or SVG (max. 5MB)"
                            field-name="logo_full"
                        />
                    </x-field>

                    <x-field>
                        <x-label>Sidebar logo (light mode)</x-label>
                        <livewire:media-upload-image
                            :model="settings()"
                            media-collection-name="logo-sidebar-light"
                            support-message="PNG, JPG, or SVG (max. 5MB)"
                            field-name="logo_sidebar_light"
                        />
                    </x-field>

                    <x-field>
                        <x-label>Sidebar logo (dark mode)</x-label>
                        <x-description>
                            If you want to use the same logo for light and dark mode, you can skip uploading a dark mode
                            logo and just add a light mode logo.
                        </x-description>

                        <livewire:media-upload-image
                            :model="settings()"
                            media-collection-name="logo-sidebar-dark"
                            support-message="PNG, JPG, or SVG (max. 5MB)"
                            field-name="logo_sidebar_dark"
                        />
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Palette" heading="Admin site theme">
                    <x-description>
                        Put your own personal touch on Nova by changing the colors used throughout the admin system. You
                        can choose from a series of pre-defined color scales or specify your own color and a color scale
                        will be created for you.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-field>
                        <x-label>Theme</x-label>

                        <div class="flex items-center gap-3" data-slot="control">
                            <div class="flex gap-3 *:size-8 *:rounded-full">
                                <div class="bg-primary-500" x-tooltip.raw="Primary color"></div>
                                <div class="bg-danger-500" x-tooltip.raw="Danger color"></div>
                                <div class="bg-info-500" x-tooltip.raw="Info color"></div>
                                <div class="bg-success-500" x-tooltip.raw="Success color"></div>
                                <div class="bg-warning-500" x-tooltip.raw="Warning color"></div>
                                <div class="bg-gray-400" x-tooltip.raw="Gray shade"></div>
                            </div>

                            <div class="flex shrink-0 items-center">
                                <x-button
                                    type="button"
                                    x-on:click="$dispatch('slide-over.open', {component: 'settings-theme-builder'})"
                                    variant="subtle"
                                    square
                                >
                                    <x-icon :name="Tabler::Settings" size="md" />
                                </x-button>
                            </div>
                        </div>
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Typography" heading="Fonts">
                    <x-description>
                        Customize Nova by changing the fonts used throughout the admin system.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-input.field>
                        <x-label>Admin headers font</x-label>
                        <livewire:settings-font-selector
                            section="admin"
                            type="header"
                            :family="$settings->adminFonts->headerFamily"
                            :provider="$settings->adminFonts->headerProvider"
                        />
                    </x-input.field>

                    <x-input.field>
                        <x-label>Admin body font</x-label>
                        <livewire:settings-font-selector
                            section="admin"
                            type="body"
                            :family="$settings->adminFonts->bodyFamily"
                            :provider="$settings->adminFonts->bodyProvider"
                        />
                    </x-input.field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::UserCircle" heading="Avatars">
                    <x-description>Update the shape and style of avatars throughout Nova.</x-description>

                    <x-description>
                        <x-avatar :src="nova()->getAvatarUrl('nova3')" size="lg" />
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-radio.group label="Shape" name="avatar_shape" variant="cards" :indicator="false">
                        @foreach (AvatarShape::cases() as $shape)
                            <x-radio
                                :label="$shape->getLabel()"
                                :value="$shape->value"
                                :checked="$settings->avatarShape === $shape"
                                :icon="$shape->getIcon()"
                            />
                        @endforeach
                    </x-radio.group>

                    <x-select
                        label="Style"
                        description="Nova uses the DiceBear avatar library for generated avatars when a user or character has not uploaded one"
                        name="avatar_style"
                    >
                        @foreach (AvatarStyle::cases() as $style)
                            <option value="{{ $style->value }}" @selected($settings->avatarStyle === $style)>
                                {{ $style->getLabel() }}
                            </option>
                        @endforeach
                    </x-select>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
