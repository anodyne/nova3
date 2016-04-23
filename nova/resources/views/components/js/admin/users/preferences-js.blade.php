<script>
	vue = {
		data: {
			search: "",
			optionGeneral: true,
			optionNotifications: false,
			optionAppearance: false
		},

		methods: {
			resetOptions: function () {
				this.optionGeneral = false
				this.optionNotifications = false
				this.optionAppearance = false
			},

			switchOption: function (option) {
				this.resetOptions()

				this.$set(option, true)
			}
		}
	}
</script>