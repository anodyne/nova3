@pageHeader
    @slot('pretitle', 'Presentation')
    Create Theme
@endpageHeader

<section>
    <form action="{{ route('themes.store') }}" method="post" role="form">
        @csrf

        <div class="form-section">
            <div class="form-section-column-content">
                <div class="form-section-header">Theme Info</div>
                <p class="form-section-message">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, ratione minus animi esse sit dicta, eos, atque omnis placeat enim tempora. Unde accusantium ad illo earum a sit saepe explicabo.</p>
            </div>

            <div class="flex-1">
                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="name">Name</label>
                    </div>

                    <div class="field-group">
                        <input type="text" name="name" id="name" class="field">
                    </div>
                </div>

                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="location">Location</label>
                    </div>

                    <div class="field-group">
                        <div class="field-addon font-mono text-sm text-grey-dark">themes/</div>

                        <input type="text" name="location" id="location" class="field">
                    </div>
                </div>

                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="credits">Credits</label>
                    </div>

                    <div class="field-group">
                        <textarea name="credits" id="credits" rows="5" class="field"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-column-content">
                <div class="form-section-header">Presentation</div>
                <p class="form-section-message">Set the presentation defaults you'd like to use for your theme.</p>
            </div>

            <div class="form-section-column-form">
                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="icons">Auth Layout</label>
                    </div>

                    <layout-picker name="layout_auth" type="auth"></layout-picker>
                </div>

                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="variants">Public Site Layout</label>
                    </div>

                    <layout-picker name="layout_public" type="public"></layout-picker>
                </div>

                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="variants">Admin Site Layout</label>
                    </div>

                    <layout-picker name="layout_admin" type="admin"></layout-picker>
                </div>

                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="variants">Icon Set</label>
                    </div>

                    <icon-set-picker name="icon_set"></icon-set-picker>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-column-content">
                <div class="form-section-header">Scaffolding</div>
                <p class="form-section-message">When you create your theme, Nova will create all of the necessary directories and files for your theme. These options allow you to specify additional files you want created during scaffolding.</p>
            </div>

            <div class="form-section-column-form">
                <div class="field-wrapper">
                    <div class="field-label">
                        <label for="variants">Variants</label>
                    </div>

                    <div class="field-group">
                        <input type="text" name="variants" id="variants" class="field">
                    </div>

                    <div class="field-help">
                        Enter the names of any variants you want for your theme, separated by commas.
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="button button-primary button-large">Create</button>
    </form>
</section>