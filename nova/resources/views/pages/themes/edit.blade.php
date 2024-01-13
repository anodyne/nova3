@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit theme">
            <x-slot name="actions">
                @can('viewAny', Nova\Themes\Models\Theme::class)
                    <x-button :href="route('themes.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>

            @if (settings('appearance.theme') === $theme->name)
                <x-spacing size="md">
                    <x-panel.primary icon="star" title="Current theme">
                        {{ $theme->name }} is currently set as the theme for your public-facing site. Be careful when
                        making any updates to this theme as it could impact your public-facing site.
                    </x-panel.primary>
                </x-spacing>
            @endif
        </x-panel.header>

        <x-form :action="route('themes.update', $theme)" method="PUT">
            <x-form.section
                title="Theme info"
                message="A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova."
            >
                <x-fieldset.field label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $theme->name)" />
                </x-fieldset.field>

                <x-fieldset.field label="Location" for="location" :error="$errors->first('location')">
                    <x-input.text
                        id="location"
                        name="location"
                        :value="old('location', $theme->location)"
                        leading="themes/"
                    />
                </x-fieldset.field>

                <x-fieldset.field label="Preview image filename" for="preview" :error="$errors->first('preview')">
                    <x-input.text id="preview" name="preview" :value="old('preview', $theme->preview)" />
                </x-fieldset.field>

                <x-fieldset.field
                    label="Credits"
                    for="credits"
                    help="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                >
                    <x-input.textarea id="credits" name="credits">
                        {{ old('credits', $theme->credits) }}
                    </x-input.textarea>
                </x-fieldset.field>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', $theme->status->value ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('themes.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
