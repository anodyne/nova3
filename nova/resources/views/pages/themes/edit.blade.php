@extends($meta->template)

@section('content')
    <x-page-header :title="$theme->name">
        <x-slot:pretitle>
            <a href="{{ route('themes.index') }}">Themes</a>
        </x-slot:pretitle>
    </x-page-header>

    @if ($theme->name === 'Pulsar')
        <x-panel.purple icon="star" title="Default theme">
            {{ $theme->name }} is currently set as the system default theme. Be careful when making any updates to this theme as it could impact your public-facing site.
        </x-panel.purple>
    @endif

    <x-panel>
        <x-form :action="route('themes.update', $theme)" method="PUT">
            <x-form.section title="Theme Info" message="A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $theme->name)" />
                </x-input.group>

                <x-input.group label="Location" for="location" :error="$errors->first('location')">
                    <x-input.text
                        id="location"
                        name="location"
                        :value="old('location', $theme->location)"
                        leading-add-on="themes/"
                    />
                </x-input.group>

                <x-input.group label="Preview image" for="preview" :error="$errors->first('preview')">
                    <x-input.text id="preview" name="preview" :value="old('preview', $theme->preview)" />
                </x-input.group>

                <x-input.group label="Credits" for="credits" help="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit.">
                    <x-input.textarea id="credits" name="credits">{{ old('credits', $theme->credits) }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="active" :value="old('active', $theme->active ?? '')">
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Update Theme</x-button>
                <x-link :href="route('themes.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
