<template>
    <admin-layout>
        <page-header title="Test Page"></page-header>

        <panel class="p-6">
            <p class="mb-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil modi accusantium culpa quis animi nostrum saepe, voluptate laboriosam, iusto, quas qui suscipit reprehenderit tenetur rerum eos beatae dolore aperiam deleniti. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, autem illum soluta quod nisi rerum aliquid error, porro dicta officiis nam labore? Nostrum quasi ratione quidem consequuntur, voluptatum illo non. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, repellendus? Quidem atque vero expedita commodi odit earum deleniti, perspiciatis temporibus numquam. Perspiciatis numquam sit accusantium vel, corporis aperiam aliquam eum? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illum quo quibusdam in, voluptatem cupiditate ad quod incidunt perspiciatis, quia cum nihil voluptas. Sed nam illum incidunt non voluptates sint harum. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores, maiores, dolor quia porro illo voluptatem, animi vero delectus sed quas nobis. Laboriosam perferendis dolorem, ducimus tempore fuga voluptatum hic cum.</p>

            <toggle-switch v-model="testSwitch" color="gray-600">
                <template #icon-off>
                    <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-4 w-4 text-yellow-400"
                    ><path
                        fill-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        clip-rule="evenodd"
                    /></svg>
                </template>
                <template #icon-on>
                    <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-4 w-4 text-primary-400"
                    ><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /></svg>
                </template>
                <template #content-on>
                    Dark mode
                </template>
                <template #content-off>
                    Light mode
                </template>
            </toggle-switch>

            <button class="button button-primary mt-6">Button</button>
        </panel>

        <panel class="bg-cool-gray-800 text-cool-gray-200 my-8 p-6">
            <p class="mb-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil modi accusantium culpa quis animi nostrum saepe, voluptate laboriosam, iusto, quas qui suscipit reprehenderit tenetur rerum eos beatae dolore aperiam deleniti. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, autem illum soluta quod nisi rerum aliquid error, porro dicta officiis nam labore? Nostrum quasi ratione quidem consequuntur, voluptatum illo non. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, repellendus? Quidem atque vero expedita commodi odit earum deleniti, perspiciatis temporibus numquam. Perspiciatis numquam sit accusantium vel, corporis aperiam aliquam eum? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illum quo quibusdam in, voluptatem cupiditate ad quod incidunt perspiciatis, quia cum nihil voluptas. Sed nam illum incidunt non voluptates sint harum. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores, maiores, dolor quia porro illo voluptatem, animi vero delectus sed quas nobis. Laboriosam perferendis dolorem, ducimus tempore fuga voluptatum hic cum.</p>

            <toggle-switch v-model="testSwitch" color="gray-600">
                <template #icon-off>
                    <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-4 w-4 text-yellow-400"
                    ><path
                        fill-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        clip-rule="evenodd"
                    /></svg>
                </template>
                <template #icon-on>
                    <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-4 w-4 text-primary-400"
                    ><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /></svg>
                </template>
                <template #content-on>
                    Dark mode
                </template>
                <template #content-off>
                    Light mode
                </template>
            </toggle-switch>

            <button class="button button-primary mt-6">Button</button>
        </panel>

        <panel class="bg-gray-800 text-gray-200 my-8 p-6">
            <p class="mb-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil modi accusantium culpa quis animi nostrum saepe, voluptate laboriosam, iusto, quas qui suscipit reprehenderit tenetur rerum eos beatae dolore aperiam deleniti. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, autem illum soluta quod nisi rerum aliquid error, porro dicta officiis nam labore? Nostrum quasi ratione quidem consequuntur, voluptatum illo non. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, repellendus? Quidem atque vero expedita commodi odit earum deleniti, perspiciatis temporibus numquam. Perspiciatis numquam sit accusantium vel, corporis aperiam aliquam eum? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illum quo quibusdam in, voluptatem cupiditate ad quod incidunt perspiciatis, quia cum nihil voluptas. Sed nam illum incidunt non voluptates sint harum. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores, maiores, dolor quia porro illo voluptatem, animi vero delectus sed quas nobis. Laboriosam perferendis dolorem, ducimus tempore fuga voluptatum hic cum.</p>

            <toggle-switch v-model="testSwitch" color="danger-500">
                <template #icon-off="{ styles }">
                    <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        :class="styles.iconOff"
                    ><path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" /></svg>
                </template>
                <template #icon-on="{ styles }">
                    <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        :class="styles.iconOn"
                    ><path
                        fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd"
                    /></svg>
                </template>
                Locked
            </toggle-switch>

            <button class="button button-primary mt-6">Button</button>
        </panel>

        <panel>
            <div class="px-6 py-6">
                <toggle-switch v-model="testSwitch" color="danger-500">
                    <template #icon-off="{ styles }">
                        <svg
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            :class="styles.iconOff"
                        ><path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" /></svg>
                    </template>
                    <template #icon-on="{ styles }">
                        <svg
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            :class="styles.iconOn"
                        ><path
                            fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd"
                        /></svg>
                    </template>
                    Locked
                </toggle-switch>
            </div>

            <div class="px-6 py-6">
                <button class="button button-primary">.button-primary</button>

                <button class="button button-danger">.button-danger</button>
            </div>

            <div class="px-6 py-6">
                <button class="button button-primary-soft">.button-primary-soft</button>

                <button class="button button-warning-soft">.button-warning-soft</button>

                <button class="button button-danger-soft">.button-danger-soft</button>
            </div>

            <div class="px-6 py-6">
                <button class="button button-primary button-sm">.button-sm</button>
                <button class="button button-primary">.button</button>
                <button class="button button-primary button-lg">.button-lg</button>
            </div>

            <div class="px-6 py-6">
                <button class="button button-primary button-sm">
                    <icon name="activity"></icon>
                    .button-sm
                </button>
                <button class="button button-primary">
                    <icon name="activity"></icon>
                    .button
                </button>
                <button class="button button-primary button-lg">
                    <icon name="activity"></icon>
                    .button-lg
                </button>
            </div>

            <div class="my-6">
                <button class="button button-text">.button-text</button>
                <button class="button button-soft button-text">.button-text</button>
                <button class="button button-success button-text">.button-text success</button>
                <button class="button button-warning button-text">.button-text warning</button>
                <button class="button button-danger button-text">.button-text danger</button>
                <button class="button button-info button-text">.button-text info</button>
            </div>
        </panel>
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
            testSwitch: false,
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
