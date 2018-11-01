<template>
    <div :class="wrapperClasses">
        <label
            v-if="label"
            class="field-label"
            v-text="label"
        />

        <div class="field-group">
            <textarea
                :name="name"
                :placeholder="placeholder"
                v-model="fieldValue"
                class="field"
                @input="$emit('input', fieldValue)"
            />
        </div>

        <div
            class="field-help"
            v-text="help"
        />

        <div
            v-if="hasError"
            class="field-help field-error"
            v-text="error"
        />
    </div>
</template>

<script>
export default {
    props: {
        error: { type: String },
        help: { type: String },
        label: { type: String },
        name: { type: String },
        placeholder: { type: String },
        value: {}
    },

    data () {
        return {
            fieldValue: this.value
        };
    },

    computed: {
        hasError () {
            return this.error && this.errors != '';
        },

        wrapperClasses () {
            const pieces = ['field-wrapper'];

            if (this.hasErrors) {
                pieces.push('has-error');
            }

            return pieces;
        }
    },

    watch: {
        value (newValue) {
            this.fieldValue = newValue;
        }
    }
};
</script>
