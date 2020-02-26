<script>
export default {
    name: 'Avatar',

    props: {
        imageUrl: {
            type: String,
            default: null
        },
        initials: {
            type: String,
            default: null
        },
        link: {
            type: String,
            default: null
        },
        size: {
            type: String,
            default: null
        },
        tooltip: {
            type: String,
            default: null
        }
    },

    computed: {
        hasLink () {
            return this.link !== null;
        },

        hasSize () {
            return this.size !== null;
        },

        isImage () {
            return this.imageUrl !== null;
        },

        tag () {
            if (!this.hasLink) {
                return 'div';
            }

            return 'a';
        }
    },

    methods: {
        imageElement (h) {
            return h('img', {
                class: {
                    'avatar-image': true
                },
                attrs: {
                    alt: 'avatar image',
                    src: this.imageUrl,
                    'data-cy': 'avatar-image'
                }
            });
        },

        interiorElement (h) {
            if (this.isImage) {
                return this.imageElement(h);
            }

            return this.initialsElement(h);
        },

        initialsElement (h) {
            return h('div', {
                class: {
                    'avatar-title': true,
                    'avatar-title-soft': this.initials
                }
            }, [this.initials]);
        }
    },

    render (h) {
        return h(this.tag, {
            class: {
                avatar: true,
                'avatar-link': this.hasLink,
                [`avatar-${this.size}`]: this.hasSize
            },
            attrs: {
                content: this.tooltip,
                href: this.link
            },
            directives: [
                { name: 'tippy' }
            ]
        }, [
            this.interiorElement(h)
        ]);
    }
};
</script>
