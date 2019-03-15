<template>
    <div class="switch-container">
        <div
            class="switch"
            role="checkbox"
            tabindex="0"
            :aria-checked="value.toString()"
            @click="toggle"
            @keydown.space.prevent="toggle"
        ></div>

        <div class="switch-label">
            <slot>
                {{ label }}
            </slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ToggleSwitch',

    props: {
        label: {
            type: String,
            default: ''
        },
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
