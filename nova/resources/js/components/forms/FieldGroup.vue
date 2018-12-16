<template>
    <div class="field-wrapper">
        <div v-if="hasSlot('label')" class="field-label">
            <slot name="label">
                <label>{{ label }}</label>
            </slot>
        </div>

        <div class="field-group">
            <div v-if="hasSlot('addon-start')" class="field-addon">
                <slot name="addon-start"></slot>
            </div>

            <slot></slot>

            <div v-if="hasSlot('addon-end')" class="field-addon">
                <slot name="addon-end"></slot>
            </div>
        </div>
    </div>
</template>

<script>
import SlotHelpers from '@/mixins/SlotHelpers';

export default {
    mixins: [SlotHelpers],

    props: {
        label: {
            type: String,
            default: ''
        }
    },

    computed: {
        hasAfterAddon () {
            return this.hasSlot('addon-after');
        },

        hasBeforeAddon () {
            return this.hasSlot('addon-after');
        }
    }
};
</script>
