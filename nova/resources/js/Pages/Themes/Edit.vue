<template>
    <sidebar-layout>
        <page-header :title="theme.name">
            <template #pretitle>
                <inertia-link :href="$route('themes.index')">Themes</inertia-link>
            </template>
        </page-header>

        <section class="panel">
            <form
                :action="$route('themes.update', { theme })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Theme Info</div>
                        <p class="form-section-message">A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin Nova.</p>
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
                                    v-model="form.fields.name"
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

                        <form-field label="Credits" field-id="credits">
                            <div class="field-group">
                                <textarea
                                    id="credits"
                                    v-model="form.fields.credits"
                                    name="credits"
                                    rows="5"
                                    class="field"
                                ></textarea>
                            </div>
                        </form-field>

                        <form-field>
                            <toggle-switch v-model="form.fields.active">Active</toggle-switch>
                        </form-field>
                    </div>
                </div>

                <!-- <div class="form-section">
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
                                v-model="form.fields.layoutAuth"
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
                                v-model="form.fields.layoutPublic"
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
                                v-model="form.fields.layoutAdmin"
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
                            <icon-set-picker v-model="form.fields.iconSet" name="icon_set"></icon-set-picker>
                            <input
                                type="hidden"
                                name="icon_set"
                                :value="form.iconSet"
                            >
                        </form-field>
                    </div>
                </div> -->

                <div class="form-controls">
                    <button type="submit" class="button button-primary">
                        Update
                    </button>

                    <inertia-link :href="$route('themes.index')" class="button is-secondary">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import Form from '@/Utils/Form';
import LayoutPicker from '@/Shared/Pickers/LayoutPicker';
import IconSetPicker from '@/Shared/Pickers/IconSetPicker';

export default {
    components: {
        LayoutPicker,
        IconSetPicker
    },

    props: {
        theme: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: new Form({
                name: this.theme.name,
                credits: this.theme.credits,
                layoutAuth: this.theme.layout_auth,
                layoutAdmin: this.theme.layout_admin,
                layoutPublic: this.theme.layout_public,
                iconSet: this.theme.icon_set,
                active: true
            })
        };
    },

    computed: {
        location () {
            return this.theme.location;
        }
    },

    methods: {
        submit () {
            this.form.put({
                url: this.$route('themes.update', { theme: this.theme }),
                then: (data) => {
                    this.$toast.message(`${data.name} theme was updated.`).success();

                    this.$inertia.replace(this.$route('themes.index'));
                }
            });
        }
    }
};
</script>
