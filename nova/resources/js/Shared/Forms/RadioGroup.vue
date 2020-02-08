<template>
    <slot></slot>
</template>

<script>
export default {
    name: 'RadioGroup',

    props: {
        value: {
            type: String,
            required: true
        }
    },

    provide: {
        radioGroup: this.radioGroup
    },

    data () {
        return {
            radioGroup: {
                name: this.name,
                value: this.value
            }
        };
    }
};
</script>
