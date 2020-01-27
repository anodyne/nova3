<template>
    <sidebar-layout>
        <page-header :title="theme.name">
            <template #pretitle>
                <inertia-link :href="$route('themes.index')">Themes</inertia-link>
            </template>
        </page-header>

        <section class="panel">
            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">Theme info</div>
                    <p class="form-section-message">A theme allows you to give your public-facing site the look-and-feel you want to any visitors. Using tools like regular HTML and CSS, you can show visitors the personality of your game and put your own spin Nova.</p>
                </div>

                <div class="form-section-column-form">
                    <form-field
                        label="Name"
                        field-id="name"
                        name="name"
                    >
                        <p class="font-bold">{{ theme.name }}</p>
                    </form-field>

                    <form-field
                        label="Location"
                        field-id="location"
                        name="location"
                    >
                        <p class="font-bold">themes/{{ theme.location }}</p>
                    </form-field>

                    <form-field
                        label="Credits"
                        field-id="credits"
                        name="credits"
                    >
                        <p>{{ theme.credits }}</p>
                    </form-field>
                </div>
            </div>

            <div class="form-controls">
                <inertia-link :href="$route('themes.index')" class="button">
                    Back
                </inertia-link>
            </div>
        </section>
    </sidebar-layout>
</template>

<script>
export default {
    props: {
        theme: {
            type: Object,
            required: true
        }
    }
};
</script>
