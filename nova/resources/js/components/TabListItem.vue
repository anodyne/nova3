<template>
    <div
        v-show="isActive"
        v-cloak
        class="tab-item"
    >
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'TabListItem',

    inject: ['tabListState'],

    props: {
        active: {
            type: Boolean,
            default: false
        },
        id: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: true
        }
    },

    computed: {
        isActive () {
            return this.id === this.tabListState.activeId;
        }
    }
};
</script>
