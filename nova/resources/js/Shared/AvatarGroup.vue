<template>
    <div class="flex relative z-0 overflow-hidden">
        <avatar
            v-for="(item, index) in truncatedItems"
            :key="item[keyProperty]"
            v-bind="avatarData(item, index)"
            class="text-white shadow-solid"
        ></avatar>
    </div>
</template>

<script>
import Avatar from '@/Shared/Avatar';

export default {
    name: 'AvatarGroup',

    components: { Avatar },

    props: {
        items: {
            type: Array,
            required: true
        },
        keyProperty: {
            type: String,
            default: 'id'
        },
        limit: {
            type: Number,
            default: 4
        },
        size: {
            type: String,
            default: 'md'
        }
    },

    computed: {
        truncatedItems () {
            return this.items.slice(0, this.limit);
        }
    },

    methods: {
        avatarData (item, index) {
            const startingZIndex = this.limit * 10 - 10;

            return {
                'image-url': item['image-url'],
                size: this.size,
                tooltip: item.tooltip,
                class: (index === 0) ? `z-${startingZIndex}` : `-ml-2 z-${startingZIndex - index * 10}`
            };
        }
    }
};
</script>
