<template>
    <sidebar-layout>
        <page-header :title="user.name">
            <template #pretitle>
                <inertia-link :href="$route('users.index')">Users</inertia-link>
            </template>
        </page-header>

        <section class="panel">
            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">User info</div>
                    <p class="form-section-message">For privacy reasons, users are encouraged to use a nickname instead of their real name. Additionally, user email addresses should be safeguarded at all costs and not shared with other players without the express permission of this user.</p>
                </div>

                <div class="form-section-column-form">
                    <form-field
                        label="Name"
                        field-id="name"
                        name="name"
                    >
                        <p class="font-semibold">{{ user.name }}</p>
                    </form-field>

                    <form-field
                        label="Email"
                        field-id="email"
                        name="email"
                    >
                        <p class="font-semibold">{{ user.email }}</p>
                    </form-field>

                    <form-field
                        label="Preferred pronouns"
                        field-id="pronouns"
                        name="pronouns"
                    >
                        <p class="font-semibold">{{ user.pronouns }}</p>
                    </form-field>

                    <form-field
                        label="Avatar"
                        field-id="avatar"
                        name="avatar"
                    >
                        <avatar :image-url="user.avatar_url" size="xl"></avatar>
                    </form-field>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">Roles</div>
                    <p class="form-section-message mb-6">Roles are the actions a user can take.</p>
                </div>

                <div class="form-section-column-form">
                    <div class="flex items-center flex-wrap">
                        <div v-if="user.roles.length === 0" class="flex items-center font-semibold text-warning-700">
                            <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                            <div>This user does not have any roles.</div>
                        </div>

                        <div
                            v-for="role in user.roles"
                            :key="role.id"
                            class="tag mr-2 mt-3"
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
        </section>
    </sidebar-layout>
</template>

<script>
import Avatar from '@/Shared/Avatars/Avatar';

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
