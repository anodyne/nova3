<template>
    <div class="field-wrapper" :class="styles.errors">
        <label
            class="field-label"
            :class="{ 'sr-only': !hasLabel }"
            :for="fieldId"
        >
            {{ label }}
        </label>

        <slot></slot>

        <div
            v-if="hasError"
            class="field-error"
            role="alert"
        >
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

export default {
    name: 'FormField',

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
