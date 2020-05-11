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
            @method('PUT')

            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-header-title">Theme Info</div>
                    <p class="form-section-header-message">A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova.</p>
                </div>

                <div class="form-section-content">
                    <x-form-field
                        label="Name"
                        field-id="name"
                        name="name"
                    >
                        <input
                            id="name"
                            value="{{ old('name', $theme->name) }}"
                            type="text"
                            name="name"
                            class="field"
                        >
                    </x-form-field>

                    <x-form-field
                        label="Location"
                        field-id="location"
                        name="location"
                    >
                        <x-slot name="addonBefore">
                            themes/
                        </x-slot>

                        <input
                            id="location"
                            value="{{ old('location', $theme->location) }}"
                            type="text"
                            name="location"
                            class="field"
                        >
                    </x-form-field>

                    <x-form-field label="Credits" field-id="credits">
                        <textarea
                            id="credits"
                            name="credits"
                            rows="5"
                            class="field"
                        >{{ old('credits', $theme->credits) }}</textarea>
                    </x-form-field>

                    <x-form-field label="" field-id="active">
                        <x-slot name="clean">
                            <livewire:toggle-switch
                                active="{{ $theme->active }}"
                                field-name="active"
                                label="Active"
                            />
                        </x-slot>
                    </x-form-field>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="button button-primary">Edit Theme</button>

                <a href="{{ route('themes.index') }}" class="button">
                    Cancel
                </a>
            </div>
        </form>
    </x-panel>
@endsection