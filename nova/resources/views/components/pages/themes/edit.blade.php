@pageHeader
    @slot('pretitle', 'Presentation')
    Edit Theme
@endpageHeader

<section>
    <form action="{{ route('themes.update', $theme) }}" method="post" role="form">
        @csrf
        @method('patch')

        <div class="form-section">
            <div class="form-section-column-content">
                <div class="form-section-header">Theme Info</div>
                <p class="form-section-message">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, ratione minus animi esse sit dicta, eos, atque omnis placeat enim tempora. Unde accusantium ad illo earum a sit saepe explicabo.</p>
            </div>

            <div class="flex-1">
                <form-field
                    label="Name"
                    field-id="name"
                    name="name"
                >
                    <div class="field-group">
                        <input type="text" name="name" id="name" class="field" value="{{ old('name') ?? $theme->name }}">
                    </div>
                </form-field>

                <form-field
                    label="Location"
                    field-id="location"
                    name="location"
                >
                    <div class="field-addon font-mono text-sm">themes/{{ $theme->location }}</div>
                </form-field>

                <form-field label="Credits" field-id="credits">
                    <div class="field-group">
                        <textarea name="credits" id="credits" rows="5" class="field">{{ old('credits') ?? $theme->credits }}</textarea>
                    </div>
                </form-field>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-column-content">
                <div class="form-section-header">Presentation</div>
                <p class="form-section-message">Set the presentation defaults you'd like to use for your theme.</p>
            </div>

            <div class="form-section-column-form">
                <form-field
                    label="Auth Layout"
                    field-id="layout_auth"
                    name="layout_auth"
                >
                    <layout-picker name="layout_auth" type="auth" v-model="layoutAuth"></layout-picker>
                    <input type="hidden" name="layout_auth" :value="layoutAuth">
                </form-field>

                <form-field
                    label="Public Site Layout"
                    field-id="layout_public"
                    name="layout_public"
                >
                    <layout-picker name="layout_public" type="public" v-model="layoutPublic"></layout-picker>
                    <input type="hidden" name="layout_public" :value="layoutPublic">
                </form-field>

                <form-field
                    label="Admin Site Layout"
                    field-id="layout_admin"
                    name="layout_admin"
                >
                    <layout-picker name="layout_admin" type="admin" v-model="layoutAdmin"></layout-picker>
                    <input type="hidden" name="layout_admin" :value="layoutAdmin">
                </form-field>

                <form-field
                    label="Icon Set"
                    field-id="icon_set"
                    name="icon_set"
                >
                    <icon-set-picker name="icon_set" v-model="iconSet"></icon-set-picker>
                    <input type="hidden" name="icon_set" :value="iconSet">
                </form-field>
            </div>
        </div>

        <div class="form-controls">
            <button type="submit" class="button is-primary is-large">Update</button>

            <a href="{{ route('themes.index') }}" class="button is-secondary is-large">Cancel</a>
        </div>
    </form>
</section>