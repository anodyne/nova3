<template>
    <sidebar-layout>
        <page-header title="Create Theme">
            <template #pretitle>
                <inertia-link :href="route('themes.index')">Themes</inertia-link>
            </template>
        </page-header>

        <section>
            <form
                :action="route('themes.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

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
                            <div class="field-group">
                                <div class="field-addon font-mono text-sm text-grey-400">themes/</div>

                                <input
                                    id="location"
                                    v-model="form.location"
                                    type="text"
                                    name="location"
                                    class="field"
                                    @change="suggestLocation = false"
                                >
                            </div>
                        </form-field>

                        <form-field label="Credits" field-id="credits">
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
                            <icon-set-picker v-model="form.iconSet" name="icon_set"></icon-set-picker>
                            <input
                                type="hidden"
                                name="icon_set"
                                :value="form.iconSet"
                            >
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Scaffolding</div>
                        <p class="form-section-message">When you create your theme, Nova will create all of the necessary directories and files for your theme. These options allow you to specify additional files you want created during scaffolding.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Variants"
                            field-id="variants"
                            name="variants"
                            help="Enter the names of any variants you want for your theme, separated by commas."
                        >
                            <div class="field-group">
                                <input
                                    id="variants"
                                    v-model="form.variants"
                                    type="text"
                                    name="variants"
                                    class="field"
                                >
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button is-primary is-large">Create</button>

                    <inertia-link :href="route('themes.index')" class="button is-secondary is-large">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import slug from 'slug';
import axios from '@/Utils/axios';
import { Inertia } from 'inertia-vue';
import LayoutPicker from '@/Shared/Pickers/LayoutPicker';
import IconSetPicker from '@/Shared/Pickers/IconSetPicker';

export default {
    components: {
        LayoutPicker,
        IconSetPicker
    },

    data () {
        return {
            form: {
                name: '',
                location: '',
                credits: '',
                layoutAuth: null,
                layoutAdmin: null,
                layoutPublic: null,
                iconSet: null,
                variants: ''
            },
            suggestLocation: true
        };
    },

    watch: {
        'form.name': function (newValue) {
            if (this.suggestLocation) {
                this.form.location = slug(newValue.toLowerCase());
            }
        }
    },

    methods: {
        submit () {
            axios.post(this.route('themes.store'), this.form)
                .then(() => {
                    this.$toast.message(`${this.form.name} theme was created.`).success();

                    Inertia.replace(this.route('themes.index'));
                })
                .catch((error) => {
                    this.$toast.message('There was a problem creating the theme.').error();
                });
        }
    }
};
</script>
