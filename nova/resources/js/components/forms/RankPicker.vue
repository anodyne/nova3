<template>
    <nova-picker
        :items="ranksToPass"
        :selected="selected"
    >
        <template
            slot="picker-selected-item"
            slot-scope="{ item: item }"
        >
            <rank :item="item"/>
            <span
                class="meta"
                v-text="item.info.name"
            />
        </template>

        <template slot="picker-nothing-selected">
            <rank/>
        </template>

        <template
            slot="picker-field"
            slot-scope="{ item: item }"
        >
            <input
                v-model="item.id"
                type="text"
                class="hidden"
                name="fieldName"
            >
        </template>

        <template slot="picker-list-empty-message">
            No ranks found
        </template>

        <template
            slot="picker-list-item"
            slot-scope="{ item: item }"
        >
            <rank :item="item"/>
            <span class="meta">{{ item.info.name }}</span>
        </template>
    </nova-picker>
</template>

<script>
import Rank from '../Rank.vue';
import NovaPicker from './Picker.vue';

export default {

    components: { Rank, NovaPicker },
    props: ['selected', 'ranks', 'character'],

    data () {
        return {
            ranksToPass: []
        };
    },

    created () {
        if (this.ranks != null) {
            this.ranksToPass = this.ranks;
        } else {
            axios.get(route('api.ranks')).then(({ data }) => {
                this.ranksToPass = data;
            });
        }
    }
};
</script>
