<template>
    <div>
        <page-header
            pretitle="Presentation"
            title="Edit Theme"
        ></page-header>

        <section>
            <form
                :action="route('themes.update', { theme: theme.id })"
                method="POST"
                role="form"
            >
                <csrf-token></csrf-token>
                <form-method patch></form-method>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Theme Info</div>
                        <p class="form-section-message">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, ratione minus animi esse sit dicta, eos, atque omnis placeat enim tempora. Unde accusantium ad illo earum a sit saepe explicabo.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Name"
                            field-id="name"
                            name="name"
                        >
                            <div class="field-group">
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    class="field"
                                >
                            </div>
                        </form-field>

                        <form-field
                            label="Location"
                            field-id="location"
                            name="location"
                        >
                            <div class="field-addon font-mono text-sm">themes/{{ location }}</div>
                        </form-field>

                        <form-field
                            label="Credits"
                            field-id="credits"
                        >
                            <div class="field-group">
                                <textarea
                                    id="credits"
                                    v-model="form.credits"
                                    name="credits"
                                    rows="5"
                                    class="field"
                                ></textarea>
                            </div>
                        </form-field>

                        <form-field>
                            <toggle-switch
                                v-model="form.active"
                                label="Active"
                            ></toggle-switch>
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
                            <layout-picker
                                v-model="form.layoutAuth"
                                name="layout_auth"
                                type="auth"
                            ></layout-picker>
                            <input
                                type="hidden"
                                name="layout_auth"
                                :value="form.layoutAuth"
                            >
                        </form-field>

                        <form-field
                            label="Public Site Layout"
                            field-id="layout_public"
                            name="layout_public"
                        >
                            <layout-picker
                                v-model="form.layoutPublic"
                                name="layout_public"
                                type="public"
                            ></layout-picker>
                            <input
                                type="hidden"
                                name="layout_public"
                                :value="form.layoutPublic"
                            >
                        </form-field>

                        <form-field
                            label="Admin Site Layout"
                            field-id="layout_admin"
                            name="layout_admin"
                        >
                            <layout-picker
                                v-model="form.layoutAdmin"
                                name="layout_admin"
                                type="admin"
                            ></layout-picker>
                            <input
                                type="hidden"
                                name="layout_admin"
                                :value="form.layoutAdmin"
                            >
                        </form-field>

                        <form-field
                            label="Icon Set"
                            field-id="icon_set"
                            name="icon_set"
                        >
                            <icon-set-picker
                                v-model="form.iconSet"
                                name="icon_set"
                            ></icon-set-picker>
                            <input
                                type="hidden"
                                name="icon_set"
                                :value="form.iconSet"
                            >
                        </form-field>
                    </div>
                </div>

                <div class="form-controls">
                    <button
                        type="submit"
                        class="button is-primary is-large"
                    >Update</button>

                    <a
                        :href="route('themes.index')"
                        class="button is-secondary is-large"
                    >Cancel</a>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
export default {
    name: 'EditTheme',

    props: {
        theme: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                name: this.theme.name,
                credits: this.theme.credits,
                layoutAuth: this.theme.layout_auth,
                layoutAdmin: this.theme.layout_admin,
                layoutPublic: this.theme.layout_public,
                iconSet: this.theme.icon_set,
                active: true
            }
        };
    },

    computed: {
        location () {
            return this.theme.location;
        }
    }
};
</script>
