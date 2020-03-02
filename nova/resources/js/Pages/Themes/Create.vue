<template>
    <admin-layout>
        <page-header title="Add Theme">
            <template #pretitle>
                <inertia-link :href="$route('themes.index')">Themes</inertia-link>
            </template>
        </page-header>

        <panel>
            <form
                :action="$route('themes.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">Theme Info</div>
                        <p class="form-section-header-message">A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin on Nova.</p>
                    </div>

                    <div class="form-section-content">
                        <form-field
                            label="Name"
                            field-id="name"
                            name="name"
                        >
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                name="name"
                                class="field"
                            >
                        </form-field>

                        <form-field
                            label="Location"
                            field-id="location"
                            name="location"
                        >
                            <template #addon-before>
                                themes/
                            </template>

                            <input
                                id="location"
                                v-model="form.location"
                                type="text"
                                name="location"
                                class="field"
                                @change="suggestLocation = false"
                            >
                        </form-field>

                        <form-field label="Credits" field-id="credits">
                            <textarea
                                id="credits"
                                v-model="form.credits"
                                name="credits"
                                rows="5"
                                class="field"
                            ></textarea>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">Scaffolding</div>
                        <p class="form-section-header-message">When you create your theme, Nova will create all of the necessary directories and files for your theme. These options allow you to specify additional files you want created during scaffolding.</p>
                    </div>

                    <div class="form-section-content">
                        <form-field
                            label="Variants"
                            field-id="variants"
                            name="variants"
                            help="Enter the names of any variants you want for your theme, separated by commas."
                        >
                            <input
                                id="variants"
                                v-model="form.variants"
                                type="text"
                                name="variants"
                                class="field"
                            >
                        </form-field>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="button button-primary">Add Theme</button>

                    <inertia-link :href="$route('themes.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>
    </admin-layout>
</template>

<script>
import slug from 'slug';

export default {
    data () {
        return {
            form: {
                name: '',
                location: '',
                credits: '',
                variants: ''
            },
            suggestLocation: true
        };
    },

    computed: {
        formData () {
            return {
                name: this.form.name,
                location: this.form.location,
                credits: this.form.credits,
                variants: this.form.variants
            };
        }
    },

    watch: {
        'form.name': function (val) {
            if (this.suggestLocation) {
                this.form.location = slug(val.toLowerCase());
            }
        }
    },

    methods: {
        submit () {
            this.$inertia.post(this.$route('themes.store'), this.formData);
        }
    }
};
</script>
