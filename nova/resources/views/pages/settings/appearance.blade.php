@extends($meta->template)

@inject('iconSets', 'Nova\Foundation\Icons\IconSets')

@section('content')
    <x-panel>
        <x-panel.header title="Appearance settings" message="Change the way Nova looks to match your game's design aesthetic.">
            <x-slot:controls>
                <div x-data="{}">
                    <x-button color="primary-outline" @click="$dispatch('toggle-spotlight')" leading="search">
                        Find a setting
                    </x-button>
                </div>
            </x-slot:controls>
        </x-panel.header>

        <x-form
            :action="route('settings.update', $tab)"
            method="PUT"
            id="appearance"
        >
            <x-form.section title="Theme" message="Update the way your site looks through the theme and icon set defaults.">
                <x-input.group label="Theme" for="theme">
                    <x-input.select class="mt-1 block w-full" id="theme" name="theme">
                        @foreach ($themes as $theme)
                            <option value="{{ $theme->location }}" @selected($theme->location === $settings->appearance->theme)>{{ $theme->name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Icon Set" for="icon_set">
                    <div class="flex items-center space-x-4">
                        <x-input.select class="mt-1 block w-full" id="icon_set" name="icon-set">
                            @foreach ($iconSets->getSets() as $alias => $set)
                                <option value="{{ $alias }}" @selected($alias === $settings->appearance->iconSet)>{{ $set->name() }}</option>
                            @endforeach
                        </x-input.select>

                        <div class="shrink-0">
                            @icon('dashboard', 'h-6 w-6')
                        </div>
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Logo" message="You can upload a logo that will be used in the header of the admin system as well as on the login pages.">
                <x-input.group>
                    @livewire('upload-image', [
                        'existingImage' => settings()->getFirstMediaUrl('logo'),
                        'supportMessage' => 'PNG, JPG, SVG up to 5MB',
                    ])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Colors" message="Put your own personal touch on Nova by changing the colors used throughout the admin system.">
                <x-input.group label="Gray">
                    <livewire:color-shade-picker type="gray" name="colors_gray" :selected="$settings->appearance->colorsGray" />
                </x-input.group>

                <x-input.group label="Primary color">
                    <livewire:color-shade-picker type="colors" name="colors_primary" :selected="$settings->appearance->colorsPrimary" />
                </x-input.group>

                <x-input.group label="Danger color">
                    <livewire:color-shade-picker type="colors" name="colors_danger" :selected="$settings->appearance->colorsDanger" />
                </x-input.group>

                <x-input.group label="Warning color">
                    <livewire:color-shade-picker type="colors" name="colors_warning" :selected="$settings->appearance->colorsWarning" />
                </x-input.group>

                <x-input.group label="Success color">
                    <livewire:color-shade-picker type="colors" name="colors_success" :selected="$settings->appearance->colorsSuccess" />
                </x-input.group>

                <x-input.group label="Info color">
                    <livewire:color-shade-picker type="colors" name="colors_info" :selected="$settings->appearance->colorsInfo" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" form="appearance" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
