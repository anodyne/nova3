<template>
    <div
        v-cloak
        :class="containerClasses"
    >
        <div class="avatar-image">
            <a
                v-if="type == 'link'"
                :class="imageClasses"
                :href="link"
                :style="'background-image:url(' + imageUrl + ')'"
            />

            <div
                v-if="type == 'image'"
                :class="imageClasses"
                :style="'background-image:url(' + imageUrl + ')'"
            />
        </div>

        <div
            v-if="showContent"
            class="avatar-label"
        >
            <span
                v-if="showName"
                class="avatar-title"
                v-text="displayName"
            />
            <span
                v-if="showMetadata"
                class="avatar-meta"
            >
                <slot>{{ positionName }}</slot>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: { type: Object, required: true },
        layout: { type: String, default: 'spread' },
        showContent: { type: Boolean, default: true },
        showName: { type: Boolean, default: true },
        showMetadata: { type: Boolean, default: true },
        showStatus: { type: Boolean, default: true },
        size: { type: String, default: 'md' },
        type: { type: String, default: 'link' }
    },

    computed: {
        containerClasses () {
            return [
                'avatar-container',
                `avatar-${this.layout}`,
                `avatar-${this.size}`
            ];
        },

        displayName () {
            return this.item.name;

            const pieces = [];

            if (this.isCharacter && this.item.rank != null) {
                pieces.push(this.item.rank.info.name);
            }

            pieces.push(this.item.name);

            return pieces.join(' ');
        },

        imageClasses () {
            const classes = ['avatar', this.size];

            if (this.showStatus) {
                // Character
                if (this.item.user_id !== undefined) {
                    if (this.item.isPrimaryCharacter) {
                        classes.push('primary');
                    }

                    if (this.item.user !== null && !this.item.isPrimaryCharacter) {
                        classes.push('secondary');
                    }

                    if (this.item.status == 1) {
                        classes.push('success');
                    }

                    if (this.item.status == 3) {
                        classes.push('warning');
                    }

                    if (this.item.status == 4) {
                        classes.push('danger');
                    }
                }

                // User
                if (this.item.primary_character !== undefined) {
                    if (this.item.status == 1) {
                        classes.push('success');
                    }

                    if (this.item.status == 2) {
                        classes.push('primary');
                    }

                    if (this.item.status == 3) {
                        classes.push('warning');
                    }

                    if (this.item.status == 4) {
                        classes.push('danger');
                    }
                }
            }

            return classes;
        },

        imageUrl () {
            return this.item.avatarImage;
        },

        isCharacter () {
            return _.has(this.item, 'rank_id');
        },

        isUser () {
            return _.has(this.item, 'primary_character');
        },

        link () {
            if (this.isUser) {
                return route('profile.show', { user: this.item.id });
            }

            return route('characters.bio', { character: this.item.id });
        },

        positionName () {
            if (this.isCharacter) {
                if (this.position) {
                    return this.position.name;
                }

                if (this.item.primaryPosition) {
                    return this.item.primaryPosition.name;
                }
            }

            return null;
        },

        statusTooltip () {
            if (window.Nova.user == null) {
                return null;
            }

            if (this.isCharacter) {
                if (this.item.user && this.item.status == 2) {
                    if (this.item.isPrimaryCharacter) {
                        return this.lang('characters-primary-of', { 2: this.item.user.name });
                    }
                    return this.lang('characters-character-of', { 2: this.item.user.name });
                }

                if (this.item.status == 1) {
                    return this.lang('characters-pending');
                }

                if (this.item.status == 3) {
                    return this.lang('characters-inactive');
                }

                if (this.item.status == 4) {
                    return this.lang('characters-removed');
                }

                return this.lang('characters-npc');
            }

            return null;
        }
    },

    methods: {
        lang (key, variables = '') {
            return window.lang(key, variables);
        }
    }
};
</script>
