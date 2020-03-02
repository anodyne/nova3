<template>
    <admin-layout>
        <page-header :title="theme.name">
            <template #pretitle>
                <inertia-link :href="$route('themes.index')">Themes</inertia-link>
            </template>
        </page-header>

        <panel>
            <form
                :action="$route('themes.update', { theme })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">Theme Info</div>
                        <p class="form-section-header-message">A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin Nova.</p>
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
                            <template #clean>
                                themes/{{ form.location }}
                            </template>
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

                        <form-field>
                            <template #clean>
                                <toggle-switch v-model="form.active">Active</toggle-switch>
                            </template>
                        </form-field>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="button button-primary">Update Theme</button>

                    <inertia-link :href="$route('themes.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>
    </admin-layout>
</template>

<script>
export default {
    props: {
        theme: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                id: this.theme.id,
                name: this.theme.name,
                location: this.theme.location,
                credits: this.theme.credits,
                active: true
            }
        };
    },

    computed: {
        formData () {
            return {
                name: this.form.name,
                id: this.form.id,
                credits: this.form.credits
            };
        }
    },

    methods: {
        submit () {
            this.$inertia.put(
                this.$route('themes.update', { theme: this.theme }),
                this.formData
            );
        }
    }
};
</script>
