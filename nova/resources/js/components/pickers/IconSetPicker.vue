<template>
    <div>
        <base-picker
            :items="iconSets"
            placeholder-empty-state="Select an icon set"
            placeholder-search="Find an icon set"
            :filter-function="filterIconSets"
            v-model="selectedIconSet"
        >
            <template slot-scope="{ selected }" slot="picker-select-input">
                <component
                    :is="selected.component"
                    :name="selected.icon"
                    :key="selected.value"
                    class="mr-2 text-grey-darker"
                ></component>
                {{ selected.name }}
            </template>

            <template slot-scope="{ item }" slot="picker-select-item">
                <component
                    :is="item.component"
                    :name="item.icon"
                    class="mr-2"
                ></component>
                {{ item.name }}
            </template>
        </base-picker>

        <input type="hidden" :name="name" :value="selectedIconSetValue">
    </div>
</template>

<script>
import find from 'lodash/find';
import IconFeather from '@/components/icons/IconFeather.vue';
import IconFontAwesome from '@/components/icons/IconFontAwesome.vue';
import IconMaterialDesign from '@/components/icons/IconMaterialDesign.vue';

export default {
    name: 'IconSetPicker',

    props: {
        name: {
            type: String,
            default: 'icon_set'
        }
    },

    data () {
        return {
            iconSets: [
                { id: 1, name: 'Feather Icons', value: 'feather', icon: 'feather', component: IconFeather },
                { id: 2, name: 'Font Awesome 5', value: 'fa5', icon: 'fas fa-flag', component: IconFontAwesome },
                { id: 3, name: 'Material Design', value: 'mdi', icon: 'fas fa-plane', component: IconMaterialDesign }
            ],
            selectedIconSet: null
        }
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