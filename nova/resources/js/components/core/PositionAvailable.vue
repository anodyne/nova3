<template>
    <div
        v-cloak
        :class="containerClasses"
    >
        <div
            v-show="showImage"
            class="avatar-image"
        >
            <a
                v-if="type == 'link'"
                :class="imageClasses"
                :href="joinLink"
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
                v-text="positionName"
            />
            <span
                v-if="showMetadata"
                class="avatar-meta"
            >
                <slot><a
                    :href="joinLink"
                    class="text-muted"
                >Apply Now</a></slot>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        layout: { type: String, default: 'spread' },
        position: { type: Object, required: true },
        showContent: { type: Boolean, default: true },
        showImage: { type: Boolean, default: true },
        showName: { type: Boolean, default: true },
        showMetadata: { type: Boolean, default: true },
        size: { type: String, default: '' },
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

        imageClasses () {
            return ['avatar', this.size];
        },

        imageUrl () {
            return [
                window.Nova.system.baseUrl,
                'nova',
                'resources',
                'assets',
                'svg',
                'no-avatar.svg'
            ].join('/');
        },

        joinLink () {
            return route('join');
        },

        positionName () {
            return this.position.name;
        }
    },

    methods: {
        lang (key, variables = '') {
            return window.lang(key, variables);
        }
    }
};
</script>
