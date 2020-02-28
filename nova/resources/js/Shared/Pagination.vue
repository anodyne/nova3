<template>
    <div class="flex-1 flex items-center | sm:justify-between">
        <div class="hidden | sm:block">
            <p class="text-sm leading-5 text-gray-700">
                Showing
                <span class="font-medium">{{ meta.from }}</span>
                to
                <span class="font-medium">{{ meta.to }}</span>
                of
                <span class="font-medium">{{ meta.total }}</span>
                {{ label }}
            </p>
        </div>

        <div class="flex items-center font-medium">
            <div class="flex flex-wrap items-center font-medium">
                <template v-for="(link, key) in links">
                    <div
                        v-if="link.url === null"
                        :key="key"
                        class="flex items-center justify-center rounded mx-2px h-6 w-6 leading-none text-gray-400 text-sm"
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
                        class="flex items-center justify-center cursor-pointer rounded mx-2px h-6 w-6 leading-none text-sm"
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

            <div v-if="links.length > 3" class="flex items-center border-l ml-4 pl-4 text-sm">
                <p>Go to page</p>

                <input
                    v-model="page"
                    type="text"
                    class="w-12 rounded border py-1 px-2 mx-2 text-center text-gray-700 outline-none focus:border-gray-400"
                >

                <button class="button button-text" @click.prevent="goToPage">
                    Go
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import pluralize from 'pluralize';

export default {
    name: 'Pagination',

    props: {
        links: {
            type: Array,
            required: true
        },
        meta: {
            type: Object,
            required: true
        },
        resourceLabel: {
            type: String,
            default: 'items'
        }
    },

    data () {
        return {
            page: ''
        };
    },

    computed: {
        label () {
            return pluralize(this.resourceLabel, this.meta.total);
        }
    },

    methods: {
        goToPage () {
            const query = new URLSearchParams(window.location.search);
            query.set('page', this.page);

            if (this.page > this.meta.last_page) {
                this.page = '';
                this.$toast.message('Please enter a valid page number').error();
            } else {
                this.$inertia.visit(`${this.$route(this.$route().current())}?${query.toString()}`);
            }
        }
    }
};
</script>
