<template>
    <div :class="wrapperClass">
        <label
            v-if="label"
            :class="labelClass"
            :for="id"
            v-html="label"
        />
        <div :class="fieldGroupClass">
            <input
                v-if="type != 'textarea'"
                v-bind="fieldAttributes"
                @input="$emit('input')"
                @change="$emit('change')"
            >

            <textarea
                v-if="type == 'textarea'"
                v-bind="fieldAttributes"
                @input="$emit('input')"
            />

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
            v-html="help"
        />

        <div
            v-if="hasError"
            class="field-error"
            v-html="error"
        />
    </div>
</template>

<script>
export default {
    props: {
        id: { type: String },
        max: { type: String },
        min: { type: String },
        help: { type: String },
        name: { type: String, required: true },
        rows: { type: String, default: '0' },
        step: { type: String },
        type: { type: String, default: 'text' },
        error: { type: String },
        label: { type: String },
        value: { type: String },
        disabled: { type: Boolean, default: false },
        required: { type: Boolean, default: false }
    },

    computed: {
        fieldAttributes () {
            const attrs = {};
            attr.class = this.fieldClass;
            attr.name = this.name;

            if (this.disabled) {
                attrs.disabled = true;
            }

            if (this.required) {
                attrs.required = true;
            }

            if (this.id) {
                attrs.id = this.id;
            }

            if (this.value) {
                attrs.value = this.value;
            }

            if (this.placeholder) {
                attrs.placeholder = this.placeholder;
            }

            if (this.type == 'number') {
                attrs.max = this.max;
                attrs.min = this.min;
                attrs.step = this.step;
            }

            if (this.type != 'textarea') {
                attrs.type = this.type;
            }

            if (this.type == 'textarea') {
                attrs.rows = this.rows;
            }

            return attrs;
        },

        fieldClass () {
            const pieces = ['field'];

            return pieces;
        },

        fieldGroupClass () {
            const pieces = ['field-group'];

            if (this.hasAddonAfter) {
                pieces.push('has-addon-after');
            }

            if (this.hasAddonBefore) {
                pieces.push('has-addon-before');
            }

            return pieces;
        },

        hasAddonAfter () {
            return !!this.$slots['field-addon-after'] && type != 'textarea';
        },

        hasAddonBefore () {
            return !!this.$slots['field-addon-before'] && type != 'textarea';
        },

        hasError () {
            return this.error != null;
        },

        labelClass () {
            const pieces = ['field-label'];

            return pieces;
        },

        wrapperClass () {
            const pieces = ['field-wrapper'];

            if (this.hasError) {
                pieces.push('is-invalid');
            }

            return pieces;
        }
    }
};
</script>
