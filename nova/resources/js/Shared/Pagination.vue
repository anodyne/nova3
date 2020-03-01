<template>
    <div class="flex-1 flex items-center justify-between">
        <div>
            <p class="hidden text-sm leading-5 text-gray-700 | sm:block">
                Showing
                <span class="font-medium">{{ meta.from }}</span>
                to
                <span class="font-medium">{{ meta.to }}</span>
                of
                <span class="font-medium">{{ meta.total }}</span>
                {{ label }}
            </p>
            <p class="block | sm:hidden">
                <span class="font-medium">{{ meta.from }}</span>-<span class="font-medium">{{ meta.to }}</span>
                of <span class="font-medium">{{ meta.total }}</span> {{ label }}
            </p>
        </div>

        <div class="flex | sm:hidden">
            <template v-for="(link, key) in mobileLinks">
                <div
                    v-if="link.url == null"
                    :key="key"
                    class="button opacity-75 ml-3"
                >
                    {{ link.label }}
                </div>

                <inertia-link
                    v-if="link.url != null"
                    :key="key"
                    class="button ml-3"
                    :href="link.url"
                >
                    {{ link.label }}
                </inertia-link>
            </template>
        </div>

        <div class="hidden | sm:flex sm:items-center">
            <div class="flex flex-wrap items-center font-medium">
                <template v-for="(link, key) in links">
                    <div
                        v-if="link.url === null"
                        :key="key"
                        class="flex items-center justify-center rounded mx-2px h-6 w-6 leading-5 text-gray-400 text-sm"
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
                        class="flex items-center justify-center cursor-pointer rounded mx-2px h-6 w-6 leading-5 text-sm transition ease-in-out duration-150"
                        :class="{ 'bg-gray-500 text-white': link.active, 'text-gray-600 hover:bg-gray-100 hover:text-gray-700': !link.active }"
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

            <div
                v-if="links.length > 3"
                class="hidden items-center border-l ml-4 pl-4 text-sm | sm:flex"
                @click="$refs.goToPage.focus()"
            >
                <div class="relative flex items-center rounded-md bg-gray-50 border border-gray-200 py-2 px-3 shadow-sm focus-within:bg-white focus-within:border-gray-300">
                    <div class="flex-shrink-0 inset-y-0 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm leading-5">
                            Go to page
                        </span>
                    </div>
                    <input
                        ref="goToPage"
                        v-model="page"
                        class="appearance-none block w-8 text-sm text-center leading-5 bg-transparent mx-2 focus:outline-none"
                        :placeholder="meta.current_page + 1"
                    >
                    <div class="inset-y-0 flex items-center">
                        <button
                            class="h-full py-0 px-0 border-transparent bg-transparent text-gray-500 font-medium text-sm leading-5 transition ease-in-out duration-150"
                            :class="{ 'text-gray-500 hover:text-gray-600': !page, 'text-primary-500 hover:text-primary-600': page }"
                            @click.prevent="goToPage"
                        >
                            Go
                        </button>
                    </div>
                </div>
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
        },

        mobileLinks () {
            return this.links.filter(link => link.label === 'Previous' || link.label === 'Next');
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
