<script>
export default {
    props: ['url'],

    data () {
        return {
            data: null,
            loading: true
        };
    },

    created () {
        fetch(this.url)
            .then((response) => { return response.json(); })
            .then((json) => {
                this.data = json,
                this.loading = false;
            });
    },

    methods: {
        fetch () {
            return axios.get(this.url)
                .then();
        }
    },

    render () {
        return this.$slots.default({
            data: this.data,
            loading: this.loading
        });
    }
};
</script>
