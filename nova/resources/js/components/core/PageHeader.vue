<template>
    <div class="page-header">
        <div class="page-header-content">
            <div
                v-if="hasSlot('pretitle')"
                class="page-header-pretitle"
            >
                <slot name="pretitle"></slot>
            </div>

            <div class="page-header-title">
                <slot name="title">{{ pageTitle }}</slot>
            </div>
        </div>

        <div
            v-if="hasSlot('controls')"
            class="page-header-controls"
        >
            <slot name="controls"></slot>
        </div>
    </div>
</template>

<script>
import SlotHelpers from '@/mixins/SlotHelpers';

export default {
    mixins: [SlotHelpers],

    computed: {
        pageTitle () {
            return 'TESTING';
            // return Nova.page.name;
        }
    }
};
</script>
