<template>
    <div class="field-wrapper" :class="styles.errors">
        <label
            class="field-label"
            :class="{ 'sr-only': !hasLabel }"
            :for="fieldId"
        >
            {{ label }}
        </label>

        <slot v-if="hasSlot('clean')" name="clean"></slot>

        <div v-else class="field-group">
            <div v-if="hasSlot('addon-before')" class="field-addon">
                <slot name="addon-before"></slot>
            </div>

            <slot></slot>

            <div v-if="hasSlot('addon-after')" class="field-addon">
                <slot name="addon-after"></slot>
            </div>
        </div>

        <div
            v-if="hasError"
            class="field-error"
            role="alert"
        >
            <icon name="alert-circle"></icon>
            {{ errorMessage }}
        </div>

        <div
            v-if="hasHelp"
            class="field-help"
            role="note"
        >
            {{ help }}
        </div>
    </div>
</template>

<script>
import get from 'lodash/get';
import size from 'lodash/size';
import SlotHelpers from '@/Utils/Mixins/SlotHelpers';

export default {
    name: 'FormField',

    mixins: [SlotHelpers],

    props: {
        error: {
            type: String,
            default: ''
        },
        fieldId: {
            type: String,
            default: ''
        },
        help: {
            type: String,
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: ''
        }
    },

    computed: {
        errorMessage () {
            if (this.hasError) {
                if (this.error.length > 0) {
                    return this.error;
                }

                return get(this.$page, `errors.${this.name}[0]`, '');
            }

            return false;
        },

        hasError () {
            if (this.$page == null && this.error.length === 0) {
                return false;
            }

            return this.error.length > 0 || size(this.$page.errors[this.name]) > 0;
        },

        hasHelp () {
            return this.help.length > 0;
        },

        hasLabel () {
            return this.label.length > 0;
        },

        styles () {
            return {
                errors: {
                    'has-error': this.hasError
                }
            };
        }
    }
};
</script>
