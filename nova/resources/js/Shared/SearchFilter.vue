<template>
    <div class="flex items-center py-1 px-2 rounded-full bg-white border-2 border-transparent text-gray-500 focus-within:bg-white focus-within:border-gray-400 focus-within:text-gray-600">
        <icon name="search" class="mr-2"></icon>

        <input
            autocomplete="off"
            class="relative w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
            name="search"
            type="text"
            :placeholder="placeholder"
            :value="value"
            @input="$emit('input', $event.target.value)"
        >

        <button
            v-show="!!value"
            class="ml-2 text-gray-500 hover:text-danger-500"
            @click.prevent="$emit('reset')"
        >
            <icon name="close"></icon>
        </button>
    </div>
</template>

<script>
export default {
    name: 'SearchFilter',

    props: {
        placeholder: {
            type: String,
            default: 'Find...'
        },
        value: {
            type: String,
            default: ''
        }
    }
};
</script>
