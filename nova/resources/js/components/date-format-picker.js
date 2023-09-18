import Tagify from '@yaireo/tagify';

export default (tokens) => ({
    dateFormat: '',
    tokens,

    init() {
        const tagify = new Tagify(this.$refs.dateFormatField, {
            mode: 'mix',
            pattern: '#',
            tagTextProp: 'text',
            whitelist: tokens,
            dropdown: {
                enabled: 1,
                position: 'text',
                mapValueTo: 'text',
                highlightFirst: true,
            },
        });

        tagify.on('input', (e) => {
            const { prefix } = e.detail;

            if (prefix) {
                if (e.detail.value.length > 1) {
                    tagify.dropdown.show(e.detail.value);
                }
            }
        });
    },
});
