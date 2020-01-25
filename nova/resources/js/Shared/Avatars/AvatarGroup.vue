<template>
    <div class="avatar-group">
        <avatar
            v-for="item in truncatedItems"
            :key="item[keyProperty]"
            v-bind="avatarData(item)"
        ></avatar>
    </div>
</template>

<script>
import Avatar from '@/Shared/Avatars/Avatar';

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
            default: null
        }
    },

    computed: {
        truncatedItems () {
            // Make sure we only take the first X number of items
            const items = this.items.slice(0, this.limit);

            // If we have more than the limit, we'll add an item to show how
            // many more items are in the list
            if (this.items.length > this.limit) {
                items.push({
                    initials: `+${this.items.length - this.limit}`,
                    size: this.size
                });
            }

            return items;
        }
    },

    methods: {
        avatarData (item) {
            return {
                'image-url': item['image-url'],
                initials: item.initials,
                link: item.link,
                size: this.size,
                tooltip: item.tooltip
            };
        }
    }
};
</script>
