<template>
    <div>
        <base-picker
            v-model="selectedLayout"
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

        <input
            v-model="selectedLayoutValue"
            type="hidden"
            :name="name"
        >
    </div>
</template>

<script>
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
            selectedLayout: null
        };
    },

    computed: {
        selectedLayoutValue () {
            if (this.selectedLayout === null) {
                return '';
            }

            return this.selectedLayout.value;
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
