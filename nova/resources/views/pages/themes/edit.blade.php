@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit theme">
            <x-slot name="actions">
                @can('viewAny', Nova\Themes\Models\Theme::class)
                    <x-button.text :href="route('themes.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan
            </x-slot>

            @if (settings('appearance.theme') === $theme->name)
                <x-content-box>
                    <x-panel.primary icon="star" title="Current theme">
                        {{ $theme->name }} is currently set as the theme for your public-facing site. Be careful when
                        making any updates to this theme as it could impact your public-facing site.
                    </x-panel.primary>
                </x-content-box>
            @endif
        </x-panel.header>

        <x-form :action="route('themes.update', $theme)" method="PUT">
            <x-form.section
                title="Theme info"
                message="A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $theme->name)" />
                </x-input.group>

                <x-input.group label="Location" for="location" :error="$errors->first('location')">
                    <x-input.text
                        id="location"
                        name="location"
                        :value="old('location', $theme->location)"
                        leading="themes/"
                    />
                </x-input.group>

                <x-input.group label="Preview image filename" for="preview" :error="$errors->first('preview')">
                    <x-input.text id="preview" name="preview" :value="old('preview', $theme->preview)" />
                </x-input.group>

                <x-input.group
                    label="Credits"
                    for="credits"
                    help="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                >
                    <x-input.textarea id="credits" name="credits">
                        {{ old('credits', $theme->credits) }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="status"
                        :value="old('status', $theme->status->value)"
                        on-value="active"
                        off-value="inactive"
                    >
                        Active
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('themes.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
