vue = {
	data: {
		action: "",
		component: "",
		description: "",
		key: "",
		name: ""
	},

	computed: {
		key: function () {
			if (this.component == "" || this.action == "") {
				return ""
			}

			return this.component + "." + this.action
		}
	},

	methods: {
		updateKey: function () {
			if (this.key != "") {
				var url = Nova.data.keyCheckUrl
				var postData = { key: this.key }

				this.$http.post(url, postData).then(response => {
					if (response.data.code == 0) {
						this.component = ""
						this.action = ""

						swal({
							title: "Error!",
							text: "Permission keys must be unique. Another permission is already using the key [" + postData.key + "]. Please enter a unique key.",
							type: "error",
							timer: null,
							html: true
						})
					}
				}, response => {
					swal({
						title: "Error!",
						text: "There was an error trying to check the permission key. Please try again. (Error " + response.status + ")",
						type: "error",
						timer: null,
						html: true
					})
				})
			}
		}
	}
}