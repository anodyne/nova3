<template>
    <label class="flex items-center">
        <input
            type="checkbox"
            class="form-checkbox"
            :class="checkboxClass"
            :value="value"
            @change="$emit('input', !value)"
        >
        <span class="ml-2">
            <slot></slot>
        </span>
    </label>
</template>

<script>
export default {
    name: 'FormCheckbox',

    props: {
        checkboxClass: {
            type: String,
            default: 'text-primary-500'
        },
        value: {
            type: Boolean,
            required: true
        }
    }
};
</script>
