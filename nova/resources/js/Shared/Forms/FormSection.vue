<template>
    <div class="flex flex-col px-4 pt-4 | md:flex-row md:px-6 md:pt-6">
        <div class="mb-8 w-full | md:w-96 md:mr-16 md:mb-0">
            <div class="font-semibold text-xl mb-2 text-gray-700 tracking-tight">{{ title }}</div>
            <p class="text-gray-600">
                <slot name="message">{{ message }}</slot>
            </p>
        </div>

        <div class="flex-1">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FormSection',

    props: {
        message: {
            type: String,
            default: null
        },
        title: {
            type: String,
            default: null
        }
    }
};
</script>
