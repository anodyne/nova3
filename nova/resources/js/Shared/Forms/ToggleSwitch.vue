<template>
    <label class="switch-container">
        <div class="switch">
            <input
                type="checkbox"
                :checked="value"
                @input="$emit('input', !value)"
            >
            <span class="slider round"></span>
        </div>

        <div v-if="hasSlot('default')" class="switch-label">
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
        value: {
            type: Boolean,
            required: true
        }
    }
};
</script>
