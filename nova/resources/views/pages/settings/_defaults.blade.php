@inject('iconSets', 'Nova\Foundation\Icons\IconSets')

<x-form :action="route('settings.update')" method="PUT" id="defaults">
    <x-form.section title="Presentation" message="Update the way your site looks through the theme and icon set defaults.">
        <x-input.group label="Theme" for="theme">
            <x-input.select class="mt-1 block w-full" id="theme" name="theme">
                @foreach ($themes as $theme)
                    <option value="{{ $theme->location }}" @if ($theme->location === $settings->defaults->theme) selected @endif>{{ $theme->name }}</option>
                @endforeach
            </x-input.select>
        </x-input.group>

        <x-input.group label="Icon Set" for="icon_set">
            <x-input.select class="mt-1 block w-full" id="icon_set" name="icon_set">
                @foreach ($iconSets->getSets() as $alias => $set)
                    <option value="{{ $alias }}" @if ($alias === $settings->defaults->iconSet) selected @endif>{{ $set->name() }}</option>
                @endforeach
            </x-input.select>
        </x-input.group>
    </x-form.section>

    <x-form.footer>
        <x-button type="submit" form="defaults" color="blue">Update Defaults</x-button>
    </x-form.footer>
</x-form>
