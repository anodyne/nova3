<template>
    <field-group>
        <template slot="label">
            {{ label }}
        </template>

        <input v-bind="fieldAttributes">
    </field-group>
</template>

<script>
import SlotHelpers from '@/mixins/SlotHelpers';

export default {
    mixins: [SlotHelpers],

    props: {
        label: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            default: ''
        }
    },

    computed: {
        fieldAttributes () {
            return {
                class: 'field',
                name: this.name,
                placeholder: this.placeholder,
                type: 'email'
            };
        }
    }
};
</script>
