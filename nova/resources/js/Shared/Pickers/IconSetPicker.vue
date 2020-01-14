<template>
    <base-picker
        v-model="selected"
        :items="iconSets"
        placeholder-empty-state="Select an icon set"
        placeholder-search="Find an icon set"
        :filter-function="filterIconSets"
    >
        <template v-slot:picker-select-input="{ selected }">
            <component
                :is="selected.component"
                :key="selected.value"
                :name="selected.icon"
            ></component>
            {{ selected.name }}
        </template>

        <template v-slot:picker-select-item="{ item }">
            <component :is="item.component" :name="item.icon"></component>
            {{ item.name }}
        </template>
    </base-picker>
</template>

<script>
import find from 'lodash/find';
import BasePicker from '@/Shared/Pickers/BasePicker';
import IconFeather from '@/Shared/Icons/IconFeather';

export default {
    name: 'IconSetPicker',

    components: {
        BasePicker,
        IconFeather
    },

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

            return find(this.iconSets, i => i.value === this.value);
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
