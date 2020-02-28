<template>
    <admin-layout>
        <page-header title="Test Page"></page-header>

        <section class="panel">
            <div class="my-6">
                <button class="button">.button</button>
                <button class="button button-soft">.button-soft</button>
            </div>

            <div class="my-6">
                <button class="button button-primary">.button-primary</button>
                <button class="button button-success">.button-success</button>
                <button class="button button-warning">.button-warning</button>
                <button class="button button-danger">.button-danger</button>
                <button class="button button-info">.button-info</button>
            </div>

            <div class="my-6">
                <button class="button button-primary-soft">.button-primary-soft</button>
                <button class="button button-success-soft">.button-success-soft</button>
                <button class="button button-warning-soft">.button-warning-soft</button>
                <button class="button button-danger-soft">.button-danger-soft</button>
                <button class="button button-info-soft">.button-info-soft</button>
            </div>

            <div class="my-6">
                <button class="button button-primary button-small">.button-small</button>
                <button class="button button-primary">.button</button>
                <button class="button button-primary button-large">.button-large</button>
            </div>

            <div class="my-6">
                <button class="button button-text">.button-text</button>
                <button class="button button-soft button-text">.button-text</button>
                <button class="button button-success button-text">.button-text success</button>
                <button class="button button-warning button-text">.button-text warning</button>
                <button class="button button-danger button-text">.button-text danger</button>
                <button class="button button-info button-text">.button-text info</button>
            </div>
        </section>
    </admin-layout>
</template>

<script>
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import Avatar from '@/Shared/Avatar';
import AvatarGroup from '@/Shared/AvatarGroup';

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
