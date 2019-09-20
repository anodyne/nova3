<template>
    <sidebar-layout>
        <page-header :title="role.title">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section class="panel">
            <div v-if="hasAbility('*')" class="mb-8 bg-danger-100 p-4 border border-danger-200 text-danger-600 rounded">
                The {{ role.title }} role has <em>All Abilities</em> assigned to it. Be <strong>very careful</strong> editing this role as improper changes could cause any users with this role to lose all access to the admin screens.
            </div>

            <form
                :action="route('roles.update', { role })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Role Info</div>
                        <p class="form-section-message">A role is a collection of abilities that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer abilities to give yourself more freedom to add and remove permissions for a given user.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Name"
                            field-id="title"
                            name="title"
                        >
                            <div class="field-group">
                                <input
                                    id="title"
                                    v-model="form.fields.title"
                                    type="text"
                                    name="title"
                                    class="field"
                                >
                            </div>
                        </form-field>

                        <form-field
                            label="Key"
                            field-id="name"
                            name="name"
                        >
                            <div class="field-group">
                                <input
                                    id="name"
                                    v-model="form.fields.name"
                                    type="text"
                                    name="name"
                                    class="field"
                                >
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Abilities</div>
                        <p class="form-section-message mb-6">Abilities are the actions a user can take. Feel free to add whatever abilities to this role that you see fit.</p>

                        <p class="form-section-message"><span class="font-semibold text-warning-600">Take very special care when adding or removing the <em>All Abilities</em> ability!</span></p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field label="Assign Abilities">
                            <div class="field-group">
                                <input
                                    v-model="search"
                                    type="text"
                                    class="field"
                                    placeholder="Find an ability..."
                                >

                                <a
                                    v-show="search !== ''"
                                    role="button"
                                    class="field-addon"
                                    @click="search = ''"
                                >
                                    <icon name="close"></icon>
                                </a>
                            </div>
                        </form-field>

                        <toggle-switch v-model="showAssignedAbilitiesOnly" class="mb-4">
                            Show only assigned abilities
                        </toggle-switch>

                        <div
                            v-for="(ability, index) in filteredAbilities"
                            :key="ability.id"
                            class="flex items-center justify-between w-full p-2 rounded"
                            :class="{ 'bg-gray-200': index % 2 === 0 }"
                        >
                            <div class="text-gray-600">{{ ability.title }}</div>

                            <a
                                v-if="!hasAbility(ability)"
                                role="button"
                                class="text-gray-500 hover:text-gray-600"
                                @click="addAbility(ability)"
                            >
                                <icon name="add"></icon>
                            </a>

                            <a
                                v-if="hasAbility(ability)"
                                role="button"
                                class="text-success-500"
                                @click="removeAbility(ability)"
                            >
                                <icon name="check-circle"></icon>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button is-primary">Update</button>

                    <inertia-link :href="route('roles.index')" class="button is-secondary">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import indexOf from 'lodash/indexOf';
import Form from '@/Utils/Form';

export default {
    props: {
        abilities: {
            type: Array,
            required: true
        },
        role: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: new Form({
                name: this.role.name,
                title: this.role.title,
                abilities: this.role.abilities.map(ability => ability.name)
            }),
            search: '',
            showAssignedAbilitiesOnly: true
        };
    },

    computed: {
        filteredAbilities () {
            const abilities = (!this.showAssignedAbilitiesOnly)
                ? this.abilities
                : this.abilities.filter(ability => this.hasAbility(ability));

            return abilities.filter((ability) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(ability.name) || searchRegex.test(ability.title);
            });
        }
    },

    mounted () {
        if (this.role.abilities.length === 0) {
            this.showAssignedAbilitiesOnly = false;
        }
    },

    methods: {
        addAbility (ability) {
            this.form.fields.abilities.push(ability.name);
        },

        hasAbility (ability) {
            const name = (typeof ability === 'string')
                ? ability
                : ability.name;

            return indexOf(this.form.fields.abilities, name) > -1;
        },

        removeAbility (ability) {
            const index = indexOf(this.form.fields.abilities, ability.name);

            this.form.fields.abilities.splice(index, 1);
        },

        submit () {
            this.form.put({
                url: this.route('roles.update', { role: this.role }),
                then: (data) => {
                    this.$toast.message(`${data.title} role was updated.`).success();

                    this.$inertia.replace(this.route('roles.index'));
                }
            });
        }
    }
};
</script>
