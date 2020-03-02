<template>
    <admin-layout>
        <page-header :title="user.name">
            <template #pretitle>
                <inertia-link :href="$route('users.index')">Users</inertia-link>
            </template>
        </page-header>

        <panel>
            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-header-title">User info</div>
                    <p class="form-section-header-message">For privacy reasons, users are encouraged to use a nickname instead of their real name. Additionally, user email addresses should be safeguarded at all costs and not shared with other players without the express permission of this user.</p>
                </div>

                <div class="form-section-content">
                    <form-field
                        label="Name"
                        field-id="name"
                        name="name"
                    >
                        <template #clean>
                            <p class="font-semibold">{{ user.name }}</p>
                        </template>
                    </form-field>

                    <form-field
                        label="Email"
                        field-id="email"
                        name="email"
                    >
                        <template #clean>
                            <p class="font-semibold">{{ user.email }}</p>
                        </template>
                    </form-field>

                    <form-field
                        label="Preferred pronouns"
                        field-id="pronouns"
                        name="pronouns"
                    >
                        <template #clean>
                            <p class="font-semibold">{{ user.pronouns }}</p>
                        </template>
                    </form-field>

                    <form-field
                        label="Avatar"
                        field-id="avatar"
                        name="avatar"
                    >
                        <template #clean>
                            <avatar :image-url="user.avatar_url" size="lg"></avatar>
                        </template>
                    </form-field>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-header-title">Roles</div>
                    <p class="form-section-header-message mb-6">Roles are the actions a user can take.</p>
                </div>

                <div class="form-section-content">
                    <div class="flex items-center flex-wrap">
                        <div v-if="user.roles.length === 0" class="flex items-center font-semibold text-warning-700">
                            <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                            <div>This user does not have any roles.</div>
                        </div>

                        <div
                            v-for="role in user.roles"
                            :key="role.id"
                            class="badge mr-2 mt-3"
                        >
                            {{ role.display_name }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <inertia-link :href="$route('users.index')" class="button">
                    Back
                </inertia-link>
            </div>
        </panel>
    </admin-layout>
</template>

<script>
import Avatar from '@/Shared/Avatar';

export default {
    components: { Avatar },

    props: {
        user: {
            type: Object,
            required: true
        }
    }
};
</script>
