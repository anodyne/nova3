<template>
    <div :class="wrapper">
        <div
            v-if="hasSlot('card-media')"
            class="card-media"
        >
            <slot name="card-media"/>
        </div>

        <div
            v-if="blockShouldShow"
            class="card-block"
        >
            <div
                v-if="hasSlot('card-header')"
                class="card-header"
            >
                <slot name="card-header"/>
            </div>

            <div
                v-if="hasSlot('card-title')"
                class="card-title"
            >
                <slot name="card-title"/>
            </div>

            <div
                v-if="hasSlot('card-subtitle')"
                class="card-subtitle"
            >
                <slot name="card-subtitle"/>
            </div>

            <div
                v-if="hasSlot('card-content')"
                class="card-content"
            >
                <slot name="card-content"/>
            </div>
        </div>

        <div
            v-if="hasSlot('card-footer')"
            class="card-footer"
        >
            <slot name="card-footer"/>
        </div>

        <div
            v-if="hasSlot('card-block')"
            class="card-content"
        >
            <slot name="card-block"/>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        inverted: { type: Boolean, default: false }
    },

    computed: {
        blockShouldShow () {
            return this.hasSlot('card-header') || this.hasSlot('card-title') || this.hasSlot('card-subtitle') || this.hasSlot('card-content');
        },

        wrapper () {
            const classes = ['card'];

            if (this.inverted) {
                classes.push('is-inverse');
            }

            return classes;
        }
    },

    methods: {
        hasSlot (slotName) {
            return !!this.$slots[slotName];
        }
    }
};
</script>
