<template>
    <div class="mb-8 | sm:flex sm:items-center sm:justify-between" data-cy="page-header">
        <div class="flex-1 min-w-0">
            <div v-if="hasPreTitle" class="block mb-2 leading-none text-sm text-gray-600 font-semibold uppercase tracking-wide">
                <slot name="pretitle" v-bind="pretitleProps">{{ pretitle }}</slot>
            </div>

            <div class="block text-2xl font-extrabold leading-7 text-gray-900 | sm:text-3xl sm:leading-9 sm:truncate" data-cy="page-header-title">
                <slot>{{ title }}</slot>
            </div>
        </div>

        <div
            v-if="hasSlot('controls')"
            class="inline-flex items-center w-auto mt-4 | sm:mt-0"
            data-cy="page-header-controls"
        >
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
        },

        pretitleProps () {
            return {
                linkStyle: 'no-underline text-gray-500 font-semibold transition ease-in-out duration-150 hover:text-gray-600'
            };
        }
    }
};
</script>
