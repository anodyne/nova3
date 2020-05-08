<x-page-header title="Add Theme">
    <x-slot name="pretitle">
        <a href="{{ route('themes.index') }}">Themes</a>
    </x-slot>
</x-page-header>

<x-panel
    x-data="{ suggestLocation = true, name = 'Foo', location = 'foo' }"
    {{-- x-init="$watch('name', value => location = value)" --}}
>
    <form action="{{ route('themes.store') }}" method="POST" role="form">
        @csrf

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">Theme Info</div>
                <p class="form-section-header-message">A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova.</p>
            </div>

            <div class="form-section-content">
                <x-form.field
                    label="Name"
                    field-id="name"
                    name="name"
                >
                    <input
                        x-model="name"
                        id="name"
                        value="{{ old('name') }}"
                        type="text"
                        name="name"
                        class="field"
                    >
                </x-form.field>

                <x-form.field
                    label="Location"
                    field-id="location"
                    name="location"
                >
                    <x-slot name="addonBefore">
                        themes/
                    </x-slot>

                    <input
                        x-model="location"
                        {{-- x-on:change="suggestLocation = false" --}}
                        id="location"
                        value="{{ old('location') }}"
                        type="text"
                        name="location"
                        class="field"
                    >
                </x-form.field>

                <x-form.field label="Credits" field-id="credits">
                    <textarea
                        id="credits"
                        name="credits"
                        rows="5"
                        class="field"
                    >
                        {{ old('credits') }}
                    </textarea>
                </x-form.field>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">Scaffolding</div>
                <p class="form-section-header-message">When you create your theme, Nova will create all of the necessary directories and files for your theme. These options allow you to specify additional files you want created during scaffolding.</p>
            </div>

            <div class="form-section-content">
                <x-form.field
                    label="Variants"
                    field-id="variants"
                    name="variants"
                    help="Enter the names of any variants you want for your theme, separated by commas."
                >
                    <input
                        id="variants"
                        value="{{ old('variants') }}"
                        type="text"
                        name="variants"
                        class="field"
                    >
                </x-form.field>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="button button-primary">Add Theme</button>

            <a href="{{ route('themes.index') }}" class="button">
                Cancel
            </a>
        </div>
    </form>
</x-panel>