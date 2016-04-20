<script>
	vue = {
		data: {
			search: "",
			optionBasic: true,
			optionEmail: false,
			optionAppearance: false
		},

		methods: {
			resetOptions: function () {
				this.optionBasic = false
				this.optionEmail = false
				this.optionAppearance = false
			},

			switchOption: function (option) {
				this.resetOptions()

				this.$set(option, true)
			}
		}
	}
</script>