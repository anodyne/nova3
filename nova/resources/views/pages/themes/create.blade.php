@extends($meta->template)

@section('content')
    <x-panel
        x-data="{ name: '{{ old('name') }}', location: '{{ old('location') }}', suggestLocation: true }"
        x-init="$watch('name', value => {
            if (suggestLocation) {
                location = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
    >
        <x-panel.header title="Add a new theme">
            <x-slot name="actions">
                @can('viewAny', Nova\Themes\Models\Theme::class)
                    <x-button :href="route('themes.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('themes.store')">
            <x-form.section
                title="Theme info"
                message="A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" id="name" name="name" />
                </x-input.group>

                <x-input.group label="Location" for="location" :error="$errors->first('location')">
                    <x-input.text
                        x-model="location"
                        x-on:change="suggestLocation = false"
                        id="location"
                        name="location"
                        leading="themes/"
                    />
                </x-input.group>

                <x-input.group label="Preview image filename" for="preview" :error="$errors->first('preview')">
                    <x-input.text id="preview" name="preview" />
                </x-input.group>

                <x-input.group
                    label="Credits"
                    for="credits"
                    help="We strongly encourage providing detailed credits for your theme. If you used an icon set or borrowed code from someone or even got inspiration from another site, this is the place to provide the appropriate credit."
                >
                    <x-input.textarea id="credits" name="credits">{{ old('credits') }}</x-input.textarea>
                </x-input.group>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.section
                title="Scaffolding"
                message="When you create your theme, Nova will create all of the necessary directories and files for your theme. These options allow you to specify additional files you want created during scaffolding."
            >
                <x-input.group
                    label="Variants"
                    for="variants"
                    help="Enter the names of any variants you want for your theme, separated by commas."
                >
                    <x-input.text id="variants" name="variants" value="{{ old('variants') }}" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('themes.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
