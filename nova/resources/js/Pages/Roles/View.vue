<template>
    <admin-layout>
        <page-header :title="role.display_name">
            <template #pretitle>
                <inertia-link :href="$route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <panel>
            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-header-title">Role info</div>
                    <p class="form-section-header-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova.</p>
                </div>

                <div class="form-section-content">
                    <form-field
                        label="Name"
                        field-id="display_name"
                        name="display_name"
                    >
                        <template #clean>
                            <p class="font-semibold">{{ role.display_name }}</p>
                        </template>
                    </form-field>

                    <form-field
                        label="Key"
                        field-id="name"
                        name="name"
                    >
                        <template #clean>
                            <p class="font-semibold">{{ role.name }}</p>
                        </template>
                    </form-field>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-header-title">Permissions</div>
                    <p class="form-section-header-message mb-6">Permissions are the actions a user can take.</p>
                </div>

                <div class="form-section-content">
                    <div class="flex items-center flex-wrap">
                        <div v-if="role.permissions.length === 0" class="flex items-center font-medium text-warning-600">
                            <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6 text-warning-400"></icon>
                            <div>There are no permissions assigned to this role.</div>
                        </div>

                        <div
                            v-for="permission in role.permissions"
                            :key="permission.id"
                            class="badge mr-2 mt-3"
                        >
                            {{ permission.display_name }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-header-title">Users with this role</div>
                    <p class="form-section-header-message">There are {{ role.usersCount }} users who have been assigned this role.</p>
                </div>

                <div class="form-section-content">
                    <div class="flex items-center flex-wrap">
                        <div v-if="role.users.length === 0" class="flex items-center font-medium text-warning-600">
                            <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6 text-warning-400"></icon>
                            <div>There are no users with this role.</div>
                        </div>

                        <div
                            v-for="user in role.users"
                            :key="user.id"
                            class="badge mr-2 mt-3"
                        >
                            {{ user.name }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <inertia-link :href="$route('roles.index')" class="button">
                    Back
                </inertia-link>
            </div>
        </panel>
    </admin-layout>
</template>

<script>
export default {
    props: {
        role: {
            type: Object,
            required: true
        }
    }
};
</script>
