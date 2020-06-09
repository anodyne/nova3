@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$theme->name">
        <x-slot name="pretitle">
            <a href="{{ route('themes.index') }}">Themes</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        @if ($theme->name === 'Pulsar')
            <div class="bg-info-100 border-t border-b border-info-200 p-4 | sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('star', 'h-6 w-6 text-info-600')
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-info-900">
                            Default theme
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-info-800">
                            <p>{{ $theme->name }} is currently set as the system default theme. Be careful when making any updates to this theme as it could impact your public-facing site.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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

                <x-input.group label="Preview image" for="preview" :error="$errors->first('preview')">
                    <x-input.text id="preview" name="preview" :value="old('preview', $theme->preview)" />
                </x-input.group>

                <x-input.group label="Credits" for="credits" help="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit.">
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
                <button type="submit" class="button button-primary">Update Theme</button>

                <a href="{{ route('themes.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </form>
    </x-panel>
@endsection
