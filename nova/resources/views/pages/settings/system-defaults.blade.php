@extends($meta->template)

@inject('iconSets', 'Nova\Foundation\Icons\IconSets')

@section('content')
<x-page-header title="System Defaults Settings">
    <x-slot name="controls">
        <x-button size="sm" onclick="Livewire.emit('openModal', 'settings:find-settings')">
            @icon('search', 'h-5 w-5')
            <span class="ml-2">Find a setting</span>
        </x-button>
    </x-slot>
</x-page-header>

<x-panel>
    <x-form
        :action="route('settings.update', $tab)"
        method="PUT"
        id="system-defaults"
    >
        <x-form.section title="Presentation" message="Update the way your site looks through the theme and icon set defaults.">
            <x-input.group label="Theme" for="theme">
                <x-input.select class="mt-1 block w-full" id="theme" name="theme">
                    @foreach ($themes as $theme)
                        <option value="{{ $theme->location }}" @if ($theme->location === $settings->system_defaults->theme) selected @endif>{{ $theme->name }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>

            <x-input.group label="Icon Set" for="icon_set">
                <x-input.select class="mt-1 block w-full" id="icon_set" name="icon-set">
                    @foreach ($iconSets->getSets() as $alias => $set)
                        <option value="{{ $alias }}" @if ($alias === $settings->system_defaults->iconSet) selected @endif>{{ $set->name() }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Game Ratings" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia quam eius provident ex modi nam, at ullam quia labore similique.">
            <x-input.group label="Language" class="w-72">
                <x-rating :value="0" />
            </x-input.group>

            <x-input.group label="Sex" class="w-72">
                <x-rating :value="1" />
            </x-input.group>

            <x-input.group label="Violence" class="w-72">
                <x-rating :value="3" />
            </x-input.group>
        </x-form.section>

        <x-form.footer>
            <x-button type="submit" form="system-defaults" color="blue">Update</x-button>
        </x-form.footer>
    </x-form>
</x-panel>
@endsection