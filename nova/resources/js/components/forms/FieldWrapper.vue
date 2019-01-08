<template>
    <div class="field-wrapper" :class="errorStyles">
        <div class="field-label" v-if="hasLabel">
            <label :for="fieldId">{{ label }}</label>
        </div>

        <slot></slot>

        <div
            class="field-error"
            role="alert"
            v-if="hasError"
        >
            {{ error }}
        </div>

        <div
            class="field-help"
            role="note"
            v-if="hasHelp"
        >
            {{ help }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'FieldWrapper',

    props: {
        error: {
            type: String,
            default: ''
        },
        fieldId: {
            type: String,
            default: '',
        },
        help: {
            type: String,
            default: '',
        },
        label: {
            type: String,
            default: ''
        }
    },

    computed: {
        errorStyles () {
            return {
                'has-error': this.hasError
            };
        },

        hasError () {
            return this.error !== '';
        },

        hasHelp () {
            return this.help !== '';
        },

        hasLabel () {
            return this.label !== '';
        }
    }
};
</script>
