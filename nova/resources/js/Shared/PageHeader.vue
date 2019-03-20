<template>
    <div class="page-header">
        <div class="page-header-content">
            <div v-if="hasPreTitle" class="page-header-pretitle">
                {{ pretitle }}
            </div>

            <div class="page-header-title">
                <slot>{{ title }}</slot>
            </div>
        </div>

        <div v-if="hasSlot('controls')" class="page-header-controls">
            <slot name="controls"></slot>
        </div>
    </div>
</template>

<script>
import SlotHelpers from '@/mixins/SlotHelpers';

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
            return this.pretitle !== '';
        }
    }
};
</script>
