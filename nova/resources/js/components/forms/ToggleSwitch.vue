<template>
    <div
        class="switch"
        role="checkbox"
        tabindex="0"
        :aria-checked="value.toString()"
        @click="toggle"
        @keydown.space.prevent="toggle"
    ></div>
</template>

<script>
export default {
    name: 'ToggleSwitch',

    props: {
        value: {
            type: Boolean,
            required: true
        }
    },

    methods: {
        toggle () {
            this.$emit('input', !this.value);
        }
    }
};
</script>
