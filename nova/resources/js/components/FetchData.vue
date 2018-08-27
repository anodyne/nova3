<script>
	export default {
		props: ['url'],

		data () {
			return {
				data: null,
				loading: true
			}
		},

		methods: {
			fetch () {
				return axios.get(this.url)
					.then()
			}
		},

		created () {
			fetch(this.url)
				.then(response => response.json())
				.then(json => {
					this.data = json,
					this.loading = false
				})
		},

		render () {
			return this.$slots.default({
				data: this.data,
				loading: this.loading
			})
		}
	}
</script>
