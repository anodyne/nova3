<template>
    <portal :disabled="false">
        <div
            v-if="showModal"
            class="fixed bottom-0 inset-x-0 px-4 pb-6 | sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center"
            @click="close"
        >
            <transition
                enter-active-class="ease-out duration-300"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
                appear
                @before-leave="backdropLeaving = true"
                @after-leave="backdropLeaving = false"
            >
                <div v-if="showBackdrop" class="fixed inset-0 transition-opacity z-99">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
            </transition>

            <transition
                enter-active-class="ease-out duration-300"
                enter-class="opacity-0 translate-y-4 | sm:translate-y-0 sm:scale-95"
                enter-to-class="opacity-100 translate-y-0 | sm:scale-100"
                leave-active-class="ease-in duration-200"
                leave-class="opacity-100 translate-y-0 | sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 | sm:translate-y-0 sm:scale-95"
                appear
                @before-leave="cardLeaving = true"
                @after-leave="cardLeaving = false"
            >
                <div
                    v-if="showContent"
                    class="relative z-999 bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all | sm:w-full sm:p-6"
                    :class="{ 'sm:max-w-sm': !hasSlot('advanced'), 'sm:max-w-lg': hasSlot('advanced') }"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modal-headline"
                    data-cy="modal"
                >
                    <div>
                        <div v-if="hasSlot('icon')" :class="`mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-${color}-100`">
                            <slot name="icon"></slot>
                        </div>

                        <div class="mt-3 text-center | sm:mt-5">
                            <h3
                                id="modal-headline"
                                class="text-lg leading-6 font-medium text-gray-900"
                                data-cy="modal-title"
                            >
                                {{ title }}
                            </h3>

                            <div
                                v-if="hasSlot('advanced')"
                                class="mt-2"
                                data-cy="modal-body"
                            >
                                <slot name="advanced" v-bind="modalProps"></slot>
                            </div>

                            <div
                                v-if="hasSlot('default')"
                                class="mt-2"
                                data-cy="modal-body"
                            >
                                <slot></slot>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="hasSlot('footer')"
                        class="mt-5 | sm:mt-6"
                        :class="{ 'sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense': hasSlot('advanced') }"
                        data-cy="modal-footer"
                    >
                        <slot name="footer" :close="close"></slot>
                    </div>
                </div>
            </transition>
        </div>
    </portal>
</template>

<script>
import Mousetrap from 'mousetrap';
import SlotHelpers from '@/Utils/Mixins/SlotHelpers';

export default {
    name: 'Modal',

    mixins: [SlotHelpers],

    props: {
        color: {
            type: String,
            default: 'gray'
        },
        title: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            backdropLeaving: false,
            cardLeaving: false,
            item: null,
            open: false,
            showBackdrop: false,
            showContent: false,
            showModal: false
        };
    },

    computed: {
        leaving () {
            return this.backdropLeaving || this.cardLeaving;
        },

        modalProps () {
            return {
                item: this.item
            };
        }
    },

    watch: {
        open: {
            handler (newValue) {
                if (newValue) {
                    this.show();
                } else {
                    this.close();
                }
            },
            immediate: true
        },

        leaving (newValue) {
            if (newValue === false) {
                this.showModal = false;
                this.open = false;
                this.item = null;
                this.$emit('close');
            }
        }
    },

    created () {
        Mousetrap.bind('esc', () => {
            this.close();
        });
    },

    mounted () {
        this.$root.$on('open-modal', (item) => {
            this.item = item;
            this.open = true;
        });
    },

    methods: {
        close () {
            this.showBackdrop = false;
            this.showContent = false;
        },

        show () {
            this.showModal = true;
            this.showBackdrop = true;
            this.showContent = true;
        }
    }
};
</script>
