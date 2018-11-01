<template>
    <div :class="wrapperClasses">
        <label
            v-if="label"
            class="field-label"
            v-text="label"
        />

        <div :class="groupClasses">
            <input
                :type="type"
                :name="name"
                :placeholder="placeholder"
                v-model="fieldValue"
                class="field"
                @input="$emit('input', fieldValue)"
            >

            <div
                v-if="hasAddonBefore"
                class="addon-before"
            >
                <slot name="field-addon-before"/>
            </div>
            <div
                v-if="hasAddonAfter"
                class="addon-after"
            >
                <slot name="field-addon-after"/>
            </div>
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
        type: { type: String, default: 'text' },
        value: {}
    },

    data () {
        return {
            fieldValue: this.value
        };
    },

    computed: {
        groupClasses () {
            const pieces = ['field-group'];

            if (this.hasAddonBefore) {
                pieces.push('has-addon-before');
            }

            if (this.hasAddonAfter) {
                pieces.push('has-addon-after');
            }

            return pieces;
        },

        hasAddonAfter () {
            return !!this.$slots['field-addon-after'];
        },

        hasAddonBefore () {
            return !!this.$slots['field-addon-before'];
        },

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
