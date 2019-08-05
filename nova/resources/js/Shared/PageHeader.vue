<template>
    <div class="flex flex-col items-center justify-between lg:flex-row">
        <div class="flex items-center w-full">
            <div class="flex items-center leading-none text-gray-800 font-bold uppercase tracking-widest">
                <slot>{{ title }}</slot>
            </div>

            <div v-if="hasPreTitle" class="flex items-center text-gray-500 font-medium">
                <div class="mx-3 text-xl">/</div>
                <slot name="pretitle">{{ pretitle }}</slot>
            </div>
        </div>

        <div v-if="hasSlot('controls')" class="page-header-controls">
            <slot name="controls"></slot>
        </div>
    </div>
</template>

<script>
import SlotHelpers from '@/Utils/Mixins/SlotHelpers';

export default {
    name: 'PageHeader',

    mixins: [SlotHelpers],

    props: {
        pretitle: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            default: ''
        }
    },

    computed: {
        hasPreTitle () {
            return this.pretitle !== '' || this.hasSlot('pretitle');
        }
    }
};
</script>
