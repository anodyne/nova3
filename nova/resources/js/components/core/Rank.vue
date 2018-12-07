<template>
    <div class="rank-container">
        <div
            :style="overlayStyle()"
            class="rank-overlay"
        />
        <div
            :style="baseStyle()"
            class="rank-base"
        />
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            default: () => { return {}; }
        },
        base: {
            type: String,
            default: ''
        },
        overlay: {
            type: String,
            default: ''
        }
    },

    methods: {
        baseStyle () {
            const image = (this.item) ? this.item.base : this.base;
            let imagePath;

            if (image) {
                imagePath = [
                    Nova.system.baseUrl,
                    'ranks',
                    Nova.settings.rank,
                    'base',
                    image
                ].join('/');
            } else {
                imagePath = [
                    Nova.system.baseUrl,
                    'ranks',
                    Nova.settings.rank,
                    'blank.png'
                ].join('/');
            }

            return `background-image:url(${imagePath})`;
        },

        overlayStyle () {
            const image = (this.item) ? this.item.overlay : this.overlay;
            let imagePath = [].join('/');

            if (image) {
                imagePath = [
                    Nova.system.baseUrl,
                    'ranks',
                    Nova.settings.rank,
                    'overlay',
                    image
                ].join('/');
            }

            return `background-image:url(${imagePath})`;
        }
    }
};
</script>
