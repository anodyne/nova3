<template>
    <panel>
        <div class="py-8 | md:py-16">
            <img
                v-if="image != null"
                :src="imageUrl"
                alt=""
                class="block h-72 w-auto mx-auto mb-8"
            >

            <div class="flex flex-col items-center max-w-xs mx-auto | sm:max-w-sm md:max-w-xl">
                <slot>
                    <div class="block text-center text-gray-700 mb-8 leading-relaxed">
                        {{ message }}
                    </div>
                    <inertia-link :href="linkUrl" class="button button-primary">
                        {{ linkLabel }}
                        <icon name="arrow-right-circle" class="h-5 w-5 ml-3 flex-shrink-0"></icon>
                    </inertia-link>
                </slot>
            </div>
        </div>
    </panel>
</template>

<script>
export default {
    name: 'EmptyState',

    props: {
        image: {
            type: String,
            default: null
        },
        linkLabel: {
            type: String,
            default: null
        },
        linkUrl: {
            type: String,
            default: null
        },
        message: {
            type: String,
            default: null
        }
    },

    computed: {
        imageUrl () {
            return `/dist/svg/empty-states/${this.image}.svg`;
        }
    }
};
</script>
