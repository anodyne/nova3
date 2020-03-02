<template>
    <portal :disabled="false">
        <div
            v-if="showModal"
            class="fixed bottom-0 inset-x-0 px-4 pb-4 z-9999 | sm:inset-0 sm:flex sm:items-center sm:justify-center"
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
                <div v-if="showBackdrop" class="fixed inset-0 transition-opacity">
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
                    class="relative bg-white rounded-lg px-6 py-6 overflow-hidden shadow-xl transform transition-all | sm:max-w-lg sm:w-full"
                    data-cy="modal"
                >
                    <div class="hidden absolute top-0 right-0 pt-6 pr-6 | sm:block">
                        <button
                            type="button"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150"
                            @click="close"
                        >
                            <icon name="x" class="h-6 w-6"></icon>
                        </button>
                    </div>

                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-danger-100 | sm:mx-0 sm:h-10 sm:w-10">
                            <icon name="alert-triangle" class="h-6 w-6 text-danger-600"></icon>
                        </div>
                        <div class="mt-3 text-center | sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-semibold text-gray-900" data-cy="modal-title">
                                {{ title }}
                            </h3>
                            <div class="mt-3" data-cy="modal-body">
                                <p class="leading-normal text-gray-500">
                                    <slot></slot>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 | sm:flex sm:flex-row-reverse" data-cy="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </transition>
        </div>
    </portal>
</template>

<script>
import Mousetrap from 'mousetrap';

export default {
    name: 'Modal',

    props: {
        open: {
            type: Boolean,
            default: false
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
            showBackdrop: false,
            showContent: false,
            showModal: false
        };
    },

    computed: {
        leaving () {
            return this.backdropLeaving || this.cardLeaving;
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
                this.$emit('close');
            }
        }
    },

    created () {
        Mousetrap.bind('esc', () => {
            this.close();
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
