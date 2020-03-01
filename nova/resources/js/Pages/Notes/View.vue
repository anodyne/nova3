<template>
    <admin-layout>
        <page-header :title="note.title">
            <template #pretitle>
                <inertia-link :href="$route('notes.index')">Notes</inertia-link>
            </template>
        </page-header>

        <panel>
            <div class="pt-4 px-4 | md:pt-6 md:px-6">
                {{ note.content }}
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
