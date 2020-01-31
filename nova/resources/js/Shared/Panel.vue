<template>
    <section class="bg-white rounded shadow-md mb-8" :class="{ 'p-8': !noPadding }">
        <div
            v-if="hasSlot('header')"
            class="flex items-center justify-between"
            :class="{ 'py-4 px-8': noPadding }"
        >
            <slot name="header"></slot>
        </div>

        <slot></slot>

        <div
            v-if="hasSlot('footer')"
            class="flex items-center bg-gray-100 text-gray-600 text-sm rounded-b"
            :class="{ 'py-4 px-8': noPadding }"
        >
            <slot name="footer"></slot>
        </div>
    </section>
</template>

<script>
import SlotHelpers from '@/Utils/Mixins/SlotHelpers';

export default {
    name: 'Panel',

    mixins: [SlotHelpers],

    props: {
        noPadding: {
            type: Boolean,
            default: false
        }
    }
};
</script>
