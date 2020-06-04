@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$theme->name">
        <x-slot name="pretitle">
            <a href="{{ route('themes.index') }}">Themes</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <form action="{{ route('themes.update', $theme) }}" method="POST" role="form">
            @csrf
            @method('put')

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

                <x-input.group label="Credits" for="credits">
                    <x-input.textarea id="credits" name="credits">{{ old('credits', $theme->credits) }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Active"
                        inactive-text="Inactive"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Edit Theme</button>

                <a href="{{ route('themes.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </form>
    </x-panel>
@endsection
