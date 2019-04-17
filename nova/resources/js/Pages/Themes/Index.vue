<template>
    <sidebar-layout>
        <page-header title="Themes">
            <template v-if="themes.can.create" #controls>
                <inertia-link :href="route('themes.create')" class="button is-primary">
                    Create Theme
                </inertia-link>
            </template>
        </page-header>

        <install-themes
            :pending-themes="pendingThemes"
            @theme-installed="installedThemes.push($event)"
        ></install-themes>

        <transition-group
            tag="div"
            class="row"
            leave-active-class="animated fadeOut"
        >
            <div
                v-for="theme in installedThemes"
                :key="theme.id"
                class="col-6 mb-6"
            >
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ theme.name }}</div>
                        <div class="card-subtitle">themes/{{ theme.location }}</div>
                    </div>

                    <div class="card-body"></div>

                    <div class="card-footer">
                        <inertia-link
                            v-if="themes.can.update"
                            :href="route('themes.edit', { theme })"
                            class="button is-secondary"
                        >
                            <nova-icon name="edit"></nova-icon>
                        </inertia-link>
                        <a
                            v-if="themes.can.delete"
                            role="button"
                            class="button is-danger"
                            @click="confirmRemove(theme)"
                        >
                            <nova-icon name="delete"></nova-icon>
                        </a>
                    </div>
                </div>
            </div>
        </transition-group>

        <modal
            :open="modalIsShown"
            title="Delete theme?"
            @close="hideModal"
        >
            Are you sure you want to delete the {{ this.deletingItem.title }} theme?

            <template #footer>
                <button
                    type="button"
                    class="button is-danger-vivid mr-4"
                    @click="remove"
                >
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
import Form from '@/Utils/Form';
import findIndex from 'lodash/findIndex';
import InstallThemes from '@/Pages/Themes/Install';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';

export default {
    components: { InstallThemes },

    mixins: [ModalHelpers],

    props: {
        pendingThemes: {
            type: [Array, Object],
            required: true
        },
        themes: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: new Form(),
            installedThemes: this.themes.data
        };
    },

    methods: {
        confirmRemove (theme) {
            this.showModal(theme);
        },

        remove () {
            this.form.delete({
                url: this.route('themes.destroy', { theme: this.deletingItem }),
                then: (data) => {
                    const index = findIndex(this.installedThemes, { id: data.id });

                    this.$toast
                        .message(`${theme.name} theme was removed.`)
                        .success();

                    this.installedThemes.splice(index, 1);
                }
            });
        }
    }
};
</script>
