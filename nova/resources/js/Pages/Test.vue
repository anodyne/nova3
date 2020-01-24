<template>
    <sidebar-layout>
        <page-header title="Test Page"></page-header>

        <section class="panel">
            <avatar
                size="xl"
                image-url="https://api.adorable.io/avatars/285/hello@adorable.io"
                tooltip="hello@adorable.io"
                link="https://google.com"
            ></avatar>
            <avatar size="lg" image-url="https://api.adorable.io/avatars/285/woohoo@adorable.io"></avatar>
            <avatar image-url="https://api.adorable.io/avatars/285/abc@adorable.io"></avatar>
            <avatar size="sm" image-url="https://api.adorable.io/avatars/285/mystery@adorable.io"></avatar>
            <avatar size="xs" image-url="https://api.adorable.io/avatars/285/something@adorable.io"></avatar>
        </section>

        <section class="panel">
            <avatar-group :limit="2" :items="avatarItems"></avatar-group>
        </section>

        <section class="panel bg-gray-700">
            <avatar-group size="sm" :items="avatarItems"></avatar-group>
        </section>

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
import Avatar from '@/Shared/Avatars/Avatar';
import AvatarGroup from '@/Shared/Avatars/AvatarGroup';

export default {
    components: { Avatar, AvatarGroup },

    mixins: [ModalHelpers],

    data () {
        return {
            avatarItems: [
                {
                    id: 1, 'image-url': 'https://api.adorable.io/avatars/285/abc@adorable.io', tooltip: 'Tooltip', initials: 'AB'
                },
                {
                    id: 2, 'image-url': 'https://api.adorable.io/avatars/285/cab@adorable.io', tooltip: 'Tooltip', initials: 'CA'
                },
                {
                    id: 3, 'image-url': 'https://api.adorable.io/avatars/285/dvs@adorable.io', tooltip: 'Tooltip', initials: 'DV'
                },
                {
                    id: 4, 'image-url': null, tooltip: 'Tooltip', initials: 'LG'
                },
                {
                    id: 5, 'image-url': null, tooltip: 'Tooltip', initials: 'AJ'
                },
                {
                    id: 6, 'image-url': 'https://api.adorable.io/avatars/285/MGJ@adorable.io', tooltip: 'Tooltip', initials: 'MJ'
                }
            ],
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
