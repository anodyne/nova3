<template>
    <sidebar-layout>
        <page-header title="Test Page"></page-header>

        <section>
            <button
                class="button is-primary"
                type="button"
                @click="modalIsShown = true"
            >Launch modal</button>
        </section>

        <div class="panel mt-8">
            <stateful-button
                class="is-primary"
                :loading="buttonLoading"
                @click="buttonLoading = true"
            >
                Create
            </stateful-button>
        </div>

        <modal
            :open="modalIsShown"
            title="Modal title"
            @close="hideModal"
        >
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Recusandae voluptatum dolorum earum illum quod! Animi voluptates debitis molestias odio. Iure harum ea animi et fugit repudiandae vero enim quidem debitis.

            <template #footer>
                <button type="button" class="button is-primary mr-4">
                    Submit
                </button>

                <button type="button" class="button is-danger-vivid mr-4">
                    Delete
                </button>

                <button class="button is-secondary" @click="hideModal">
                    Cancel
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';

export default {
    mixins: [ModalHelpers],

    data () {
        return {
            buttonLoading: false
        };
    },

    watch: {
        buttonLoading (newValue) {
            if (newValue === true) {
                setTimeout(() => {
                    this.$toast
                        .message('There was a problem creating your thing.')
                        .actionText('OK')
                        .error();

                    this.buttonLoading = false;
                }, 3000);
            }
        }
    }
};
</script>
