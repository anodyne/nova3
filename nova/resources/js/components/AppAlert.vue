<script>
import Swal from 'sweetalert2';

export default {
    name: 'AppAlert',

    props: {
        session: {
            type: Object,
            default: null
        }
    },

    data () {
        return {
            config: null,
            message: null,
            title: null,
            type: 'success',
            show: false
        }
    },

    computed: {
        alertConfig () {
            return {
                ...{
                    buttonsStyling: false,
                    confirmButtonClass: 'button button-primary',
                    cancelButtonClass: 'button button-secondary',
                    customClass: 'alert',
                    customContainerClass: 'alert-container',
                },
                ...Nova.config.alert,
                ...this.config
            };
        }
    },

    methods: {
        alert () {
            const swalData = {
                type: this.type,
                title: this.title,
                text: this.message,
                ...this.alertConfig
            };

            console.log(swalData);

            Swal(swalData);
        },

        setAlertData (data) {
            this.message = data.content.message;
            this.type = data.content.type;
            this.title = data.content.title;
            this.config = data.config;
        }
    },

    created () {
        if (this.session) {
            this.setAlertData(this.session);

            this.alert();
        }

        Nova.$on('nova.alert', (content, config) => {
            const data = {
                content,
                config: {
                    ...this.config,
                    ...config
                }
            };

            this.setAlertData(data);

            this.alert();
        });
    },

    render () {
        return this.$slots.default;
    }
};
</script>
