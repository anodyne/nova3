<template>
    <label class="switch-container">
        <div
            class="switch"
            :class="{ 'is-small': this.small }"
            role="checkbox"
            tabindex="0"
            :aria-checked="value.toString()"
            @click="toggle"
            @keydown.space.prevent="toggle"
        ></div>

        <div
            v-if="hasSlot('default')"
            class="switch-label"
            @click="toggle"
        >
            <slot></slot>
        </div>
    </label>
</template>

<script>
import SlotHelpers from '@/Utils/Mixins/SlotHelpers';

export default {
    name: 'ToggleSwitch',

    mixins: [SlotHelpers],

    props: {
        small: {
            type: Boolean,
            default: false
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
