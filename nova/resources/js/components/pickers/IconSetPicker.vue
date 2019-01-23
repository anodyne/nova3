<template>
    <base-picker
        v-model="selected"
        :items="iconSets"
        placeholder-empty-state="Select an icon set"
        placeholder-search="Find an icon set"
        :filter-function="filterIconSets"
    >
        <template slot="picker-select-input" slot-scope="{ selected }">
            <component
                :is="selected.component"
                :key="selected.value"
                :name="selected.icon"
            ></component>
            {{ selected.name }}
        </template>

        <template slot="picker-select-item" slot-scope="{ item }">
            <component
                :is="item.component"
                :name="item.icon"
            ></component>
            {{ item.name }}
        </template>
    </base-picker>
</template>

<script>
import find from 'lodash/find';

export default {
    name: 'IconSetPicker',

    props: {
        name: {
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
            iconSets: [
                {
                    id: 1, name: 'Feather Icons', value: 'feather', icon: 'user', component: 'IconFeather'
                },
                {
                    id: 2, name: 'Font Awesome 5', value: 'fa5', icon: 'user', component: 'IconFontAwesome'
                }
            ],
            selected: null
        };
    },

    computed: {
        getSelected () {
            if (this.value === null) {
                return null;
            }

            return find(this.iconSets, (i) => {
                return i.value === this.value;
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
        filterIconSets (search, items) {
            return items.filter((item) => {
                const searchRegex = new RegExp(search, 'i');

                return searchRegex.test(item.name)
                    || searchRegex.test(item.value);
            });
        }
    }
};
</script>
