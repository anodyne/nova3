<template>
    <sidebar-layout>
        <page-header title="Test Page"></page-header>

        <section>
            <button
                class="button button-primary"
                type="button"
                @click="modalIsShown = true"
            >Launch modal</button>
        </section>

        <div class="panel mt-8">
            <stateful-button
                class="button-primary"
                :loading="buttonLoading"
                @click="buttonLoading = true"
            >
                Create
            </stateful-button>
        </div>

        <div class="panel mt-8">
            <div class="badge">Pending</div>
            <div class="badge badge-success">Success</div>
            <div class="badge badge-danger">Danger</div>
            <div class="badge badge-warning">Warning</div>
            <div class="badge badge-info">Info</div>
        </div>

        <div class="panel mt-8">
            <toggle-switch v-model="toggleSwitch">
                First Switch
            </toggle-switch>
            <toggle-switch v-model="toggleSwitch2" class="mt-2"></toggle-switch>
        </div>

        <modal
            :open="modalIsShown"
            title="Modal title"
            @close="hideModal"
        >
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Recusandae voluptatum dolorum earum illum quod! Animi voluptates debitis molestias odio. Iure harum ea animi et fugit repudiandae vero enim quidem debitis.

            <template #footer>
                <button type="button" class="button button-primary mr-4">
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
            buttonLoading: false,
            toggleSwitch: true,
            toggleSwitch2: false
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
