<template>
    <sidebar-layout>
        <page-header
            slot="header"
            title="Themes"
            pretitle="Presentation"
        ></page-header>

        <install-themes
            :pending-themes="pendingThemes"
            @theme-installed="installedThemes.push($event)"
        ></install-themes>

        <transition-group
            tag="div"
            leave-active-class="animated fadeOut"
        >
            <section
                v-for="theme in installedThemes"
                :key="theme.id"
                class="flex items-center justify-between"
            >
                <div class="flex items-center">
                    <div class="flex flex-col">
                        <div class="font-semibold">{{ theme.name }}</div>
                        <div class="text-gray-600">themes/{{ theme.location }}</div>
                    </div>
                </div>

                <div>
                    <dropdown placement="bottom-end">
                        <icon name="more-horizontal" class="h-6 w-6"></icon>

                        <template #dropdown="{ dropdownProps }">
                            <inertia-link
                                v-if="themes.can.update"
                                :href="route('themes.edit', { theme })"
                                class="dropdown-link"
                            >
                                <icon name="edit" class="dropdown-item-icon"></icon>
                                Edit
                            </inertia-link>
                            <a
                                v-if="themes.can.delete"
                                role="button"
                                class="dropdown-link-danger"
                                @click="confirmRemove(theme)"
                            >
                                <icon name="delete" class="dropdown-item-icon"></icon>
                                Delete
                            </a>
                        </template>
                    </dropdown>
                </div>
            </section>
        </transition-group>

        <modal
            :open="modalIsShown"
            title="Delete theme?"
            @close="hideModal"
        >
            Are you sure you want to delete the {{ deletingItem.title }} theme?

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
import findIndex from 'lodash/findIndex';
import Form from '@/Utils/Form';
import InstallThemes from '@/Pages/Themes/Install';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import StateButton from '@/Shared/StateButton';

export default {
    components: { InstallThemes, StateButton },

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
                        .message(`${this.installedThemes[index].name} theme was removed.`)
                        .success();

                    this.installedThemes.splice(index, 1);
                }
            });
        }
    }
};
</script>
