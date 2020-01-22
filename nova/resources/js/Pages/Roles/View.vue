<template>
    <sidebar-layout>
        <page-header :title="role.display_name">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section class="panel">
            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">Role info</div>
                    <p class="form-section-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova.</p>
                </div>

                <div class="form-section-column-form">
                    <form-field
                        label="Name"
                        field-id="display_name"
                        name="display_name"
                    >
                        <p class="font-bold">{{ role.display_name }}</p>
                    </form-field>

                    <form-field
                        label="Key"
                        field-id="name"
                        name="name"
                    >
                        <p class="font-bold">{{ role.name }}</p>
                    </form-field>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">Permissions</div>
                    <p class="form-section-message mb-6">Permissions are the actions a user can take.</p>
                </div>

                <div class="form-section-column-form">
                    <div class="flex items-center flex-wrap">
                        <div
                            v-for="permission in role.permissions"
                            :key="permission.id"
                            class="tag mr-2 mt-3"
                        >
                            {{ permission.display_name }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-column-content">
                    <div class="form-section-header">Users with this role</div>
                    <p class="form-section-message">This list shows the users who have been assigned this role.</p>
                </div>

                <div class="form-section-column-form">
                    <form-field>
                        <div class="flex items-center flex-wrap">
                            <div
                                v-for="user in role.users"
                                :key="user.id"
                                class="tag mr-2 mt-3"
                            >
                                {{ user.name }}
                            </div>
                        </div>
                    </form-field>
                </div>
            </div>

            <div class="form-controls">
                <inertia-link :href="route('roles.index')" class="button">
                    Back
                </inertia-link>
            </div>
        </section>
    </sidebar-layout>
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
