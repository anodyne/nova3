<template>
    <div>
        <base-picker
            v-model="selectedIconSet"
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
                    class="mr-2 text-grey-darker"
                ></component>
                {{ selected.name }}
            </template>

            <template slot="picker-select-item" slot-scope="{ item }">
                <component
                    :is="item.component"
                    :name="item.icon"
                    class="mr-2"
                ></component>
                {{ item.name }}
            </template>
        </base-picker>

        <input
            type="hidden"
            :name="name"
            :value="selectedIconSetValue"
        >
    </div>
</template>

<script>
export default {
    name: 'IconSetPicker',

    props: {
        name: {
            type: String,
            required: true
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
            selectedIconSet: null
        };
    },

    computed: {
        selectedIconSetValue () {
            if (this.selectedIconSet === null) {
                return '';
            }

            return this.selectedIconSet.value;
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
