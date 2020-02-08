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
                return this.$page.errors[this.name][0];
            }

            return false;
        },

        hasError () {
            if (this.$page === undefined) {
                return false;
            }

            return this.$page.errors[this.name];
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
