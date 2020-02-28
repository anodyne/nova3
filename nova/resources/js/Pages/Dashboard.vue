<template>
    <admin-layout>
        <page-header title="Dashboard"></page-header>

        <div class="panel">
            <p>Welcome to Nova 3.</p>

            <avatar-group :items="avatars"></avatar-group>

            <div class="flex justify-end mt-8">
                <dropdown placement="bottom-end" class="button button-primary">
                    Dropdown

                    <template #dropdown>
                        <a href="#" class="dropdown-link">
                            <icon name="eye" class="dropdown-icon"></icon>
                            View
                        </a>
                        <a href="#" class="dropdown-link">
                            <icon name="eye" class="dropdown-icon"></icon>
                            View
                        </a>
                        <a href="#" class="dropdown-link">
                            <icon name="eye" class="dropdown-icon"></icon>
                            View
                        </a>
                    </template>
                </dropdown>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AvatarGroup from '@/Shared/Avatars/AvatarGroup';

export default {
    components: { AvatarGroup },

    data () {
        return {
            avatars: [
                { id: 1, 'image-url': 'https://api.adorable.io/avatars/285/abc.png', tooltip: '' },
                { id: 2, 'image-url': 'https://api.adorable.io/avatars/285/def.png', tooltip: '' },
                { id: 3, 'image-url': 'https://api.adorable.io/avatars/285/ghi.png', tooltip: '' },
                { id: 4, 'image-url': 'https://api.adorable.io/avatars/285/jkl.png', tooltip: '' },
                { id: 5, 'image-url': 'https://api.adorable.io/avatars/285/xyz.png', tooltip: '' }
            ]
        };
    }
};
</script>
