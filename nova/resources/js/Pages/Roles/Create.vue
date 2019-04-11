<template>
    <sidebar-layout>
        <page-header title="Create Role">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section>
            <form
                :action="route('roles.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

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
                                    @change="suggestName = false"
                                >
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Abilities</div>
                        <p class="form-section-message mb-6">Abilities are the actions a user can take. Feel free to add whatever abilities to this role that you see fit.</p>

                        <p class="form-section-message"><span class="font-medium text-orange-500">Take very special care when adding or removing the <em>All Abilities</em> ability!</span></p>
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
                                    <nova-icon name="close"></nova-icon>
                                </a>
                            </div>
                        </form-field>

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
                                <nova-icon name="add"></nova-icon>
                            </a>

                            <a
                                v-if="hasAbility(ability)"
                                role="button"
                                class="text-green-500"
                                @click="removeAbility(ability)"
                            >
                                <nova-icon name="check-circle"></nova-icon>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button is-primary is-large">Create</button>

                    <inertia-link :href="route('roles.index')" class="button is-secondary is-large">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import slug from 'slug';
import Form from '@/Utils/Form';
import indexOf from 'lodash/indexOf';
import { Inertia } from 'inertia-vue';

export default {
    props: {
        abilities: {
            type: Array,
            required: true
        }
    },

    data () {
        return {
            form: new Form({
                title: '',
                name: '',
                abilities: []
            }),
            search: '',
            suggestName: true
        };
    },

    computed: {
        filteredAbilities () {
            return this.abilities.filter((ability) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(ability.name) || searchRegex.test(ability.title);
            });
        }
    },

    watch: {
        'form.fields.title': function (newValue) {
            if (this.suggestName) {
                this.form.fields.name = slug(newValue.toLowerCase());
            }
        }
    },

    methods: {
        addAbility (ability) {
            this.form.fields.abilities.push(ability.name);
        },

        hasAbility (ability) {
            return indexOf(this.form.fields.abilities, ability.name) > -1;
        },

        removeAbility (ability) {
            const index = indexOf(this.form.fields.abilities, ability.name);

            this.form.fields.abilities.splice(index, 1);
        },

        submit () {
            this.form.post({
                url: this.route('roles.store'),
                then: (data) => {
                    this.$toast.message(`${data.title} role was created.`).success();

                    Inertia.replace(this.route('roles.index'));
                }
            });
        }
    }
};
</script>
