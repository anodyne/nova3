<template>
    <component :is="layout">
        <component :is="component" v-bind="props"></component>
    </component>
</template>

<script>
import axios from '@/util/axios';

export default {
    name: 'NovaApp',

    props: {
        component: {
            type: String,
            required: true
        },
        props: {
            type: Object,
            required: true
        }
    },

    computed: {
        layout () {
            return 'SidebarLayout';
        }
    }
};
</script>
