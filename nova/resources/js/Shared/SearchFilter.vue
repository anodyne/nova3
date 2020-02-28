<template>
    <div class="flex items-center py-1 text-gray-500 transition duration-150 focus-within:text-gray-700">
        <icon name="search" class="mr-3 flex-shrink-0"></icon>

        <input
            autocomplete="off"
            class="relative w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
            name="search"
            type="text"
            :placeholder="placeholder"
            :value="value"
            data-cy="search-field"
            @input="$emit('input', $event.target.value)"
        >

        <button
            v-show="!!value"
            id="clear-search"
            class="ml-2 text-gray-400 hover:text-gray-500 transition ease-in-out duration-150"
            data-cy="search-clear"
            @click.prevent="$emit('reset')"
        >
            <icon name="x"></icon>
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
