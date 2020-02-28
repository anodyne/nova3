<template>
    <admin-layout>
        <page-header :title="note.title">
            <template #pretitle>
                <inertia-link :href="$route('notes.index')">Notes</inertia-link>
            </template>
        </page-header>

        <panel>
            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">Role info</div>
                    <p class="form-section-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.</p>
                </div>

                <div class="form-section-column-form">
                    <form-field
                        label="Title"
                        field-id="title"
                        name="title"
                    >
                        <p class="font-semibold">{{ note.title }}</p>
                    </form-field>

                    <form-field
                        label="Content"
                        field-id="content"
                        name="content"
                    >
                        <p>{{ note.content }}</p>
                    </form-field>
                </div>
            </div>

            <div class="form-footer">
                <inertia-link :href="$route('notes.index')" class="button">
                    Back
                </inertia-link>
            </div>
        </panel>
    </admin-layout>
</template>

<script>
export default {
    props: {
        note: {
            type: Object,
            required: true
        }
    }
};
</script>
