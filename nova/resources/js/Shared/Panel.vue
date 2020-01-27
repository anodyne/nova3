<template>
    <section class="bg-white rounded shadow-md" :class="{ 'p-6': !noPadding }">
        <div
            v-if="hasSlot('header')"
            class="flex items-center justify-between"
            :class="{ 'py-3 px-6': noPadding }"
        >
            <slot name="header"></slot>
        </div>

        <slot></slot>

        <div
            v-if="hasSlot('footer')"
            class="flex items-center bg-gray-100 text-gray-600 text-sm rounded-b"
            :class="{ 'py-3 px-6': noPadding }"
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
