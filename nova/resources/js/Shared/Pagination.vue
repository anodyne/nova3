<template>
    <div class="flex flex-wrap items-center font-medium">
        <template v-for="(link, key) in links">
            <div
                v-if="link.url === null"
                :key="key"
                class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center hover:bg-gray-300"
            >
                <template v-if="link.label === 'Previous' || link.label === 'Next'">
                    <icon v-show="link.label === 'Previous'" name="chevron-left"></icon>
                    <icon v-show="link.label === 'Next'" name="chevron-right"></icon>
                </template>
                <template v-else>
                    {{ link.label }}
                </template>
            </div>

            <inertia-link
                v-else
                :key="key"
                class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center"
                :class="{ 'bg-gray-500 text-white': link.active, 'hover:bg-gray-300': !link.active }"
                :href="link.url"
            >
                <template v-if="link.label === 'Previous' || link.label === 'Next'">
                    <icon v-show="link.label === 'Previous'" name="chevron-left"></icon>
                    <icon v-show="link.label === 'Next'" name="chevron-right"></icon>
                </template>
                <template v-else>
                    {{ link.label }}
                </template>
            </inertia-link>
        </template>
    </div>
</template>

<script>
export default {
    name: 'Pagination',

    props: {
        links: {
            type: Array,
            required: true
        }
    },

    methods: {
        getLabel (link) {
            if (link.label === 'Previous') {
                return '<icon name="chevron-left"></icon>';
            }

            return link.label;
        }
    }
};
</script>
