<template>
    <base-picker
        v-model="selected"
        :items="layouts[type]"
        placeholder-empty-state="Select a layout"
        placeholder-search="Find a layout"
        :filter-function="filterLayouts"
    >
        <template slot="picker-select-input" slot-scope="{ selected }">
            {{ selected.name }}
        </template>

        <template slot="picker-select-item" slot-scope="{ item }">
            {{ item.name }}
        </template>
    </base-picker>
</template>

<script>
import find from 'lodash/find';

export default {
    name: 'LayoutPicker',

    props: {
        name: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        value: {
            type: [String, Object, Number],
            default: null
        }
    },

    data () {
        return {
            layouts: {
                auth: [
                    { id: 1, name: 'Simple', value: 'auth-simple' },
                    { id: 2, name: 'Cover', value: 'auth-cover' },
                    { id: 3, name: 'Two Pane', value: 'auth-two-pane' }
                ],
                public: [
                    { id: 4, name: 'Sidebar', value: 'app-sidebar' },
                    { id: 5, name: 'Top Nav', value: 'app-topnav' },
                    { id: 6, name: 'Combo', value: 'app-sidebar-topnav' },
                    { id: 7, name: 'Hero', value: 'app-hero' }
                ],
                admin: [
                    { id: 8, name: 'Sidebar', value: 'app-sidebar' },
                    { id: 9, name: 'Top Nav', value: 'app-topnav' },
                    { id: 10, name: 'Combo', value: 'app-sidebar-topnav' },
                    { id: 11, name: 'Hero', value: 'app-hero' }
                ]
            },
            selected: null
        };
    },

    computed: {
        getSelected () {
            if (this.value === null) {
                return null;
            }

            return find(this.layouts[this.type], (layout) => {
                return layout.value === this.value;
            });
        }
    },

    watch: {
        selected (newValue) {
            this.$emit('input', newValue.value);
        }
    },

    mounted () {
        if (this.selected === null) {
            this.selected = this.getSelected;
        }
    },

    methods: {
        filterLayouts (search, items) {
            return items.filter((item) => {
                const searchRegex = new RegExp(search, 'i');

                return searchRegex.test(item.name);
            });
        }
    }
};
</script>
