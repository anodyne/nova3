<template>
    <div class="field-wrapper" :class="styles.errors">
        <div v-if="hasLabel" class="field-label">
            <label :for="fieldId">{{ label }}</label>
        </div>

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
export default {
    name: 'FormField',

    props: {
        error: {
            type: String,
            default: null
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
                if (this.error) {
                    return this.error;
                }

                return this.$page.errors[this.name][0];
            }

            return false;
        },

        hasError () {
            if (this.$page === undefined && this.error === null) {
                return false;
            }

            if (this.$page === undefined && this.error) {
                return true;
            }

            if (this.error === null && this.$page.errors.length > 0) {
                return true;
            }

            return false;
        },

        hasHelp () {
            return this.help !== '';
        },

        hasLabel () {
            return this.label !== '';
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
