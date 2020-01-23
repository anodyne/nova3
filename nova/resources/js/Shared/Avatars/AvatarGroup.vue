<template>
    <div class="avatar-group">
        <avatar
            v-for="item in finalItems"
            :key="item.title"
            :size="size"
            v-bind="item"
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
        size: {
            type: String,
            default: ''
        }
    },

    computed: {
        finalItems () {
            const items = this.items.slice(0, 4);

            if (this.items.length > 4) {
                items.push({ url: '', title: `+${this.items.length - 4}` });
            }

            return items;
        }
    }
};
</script>
