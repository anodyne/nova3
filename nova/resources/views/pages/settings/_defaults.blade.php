@inject('iconSets', 'Nova\Foundation\Icons\IconSets')

<x-form.section title="Presentation" message="Update the way your site looks through the theme and icon set defaults.">
    <x-input.group label="Theme" for="theme" class="sm:w-2/3">
        <select class="form-select mt-1 block w-full" id="theme" name="theme">
            @foreach ($themes as $theme)
                <option value="{{ $theme->location }}">{{ $theme->name }}</option>
            @endforeach
        </select>
    </x-input.group>

    <x-input.group label="Icon Set" for="icon_set" class="sm:w-2/3">
        <select class="form-select mt-1 block w-full" id="icon_set" name="icon_set">
            @foreach ($iconSets->getSets() as $alias => $set)
                <option value="{{ $alias }}">{{ $set->name() }}</option>
            @endforeach
        </select>
    </x-input.group>
</x-form.section>

<x-form.footer>
    <button type="submit" class="button button-primary">Update Defaults</button>
</x-form.footer>