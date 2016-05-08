vue = {
	data: {
		description: "",
		displayName: "",
		key: "",
		oldKey: ""
	},

	ready: function () {
		this.oldKey = this.key
	},

	methods: {
		updateKey: function () {
			if (this.key != "" && this.key != this.oldKey) {
				var url = Nova.data.keyCheckUrl
				var postData = { key: this.key }

				this.$http.post(url, postData).then(response => {
					if (response.data.code == 0) {
						this.key = this.oldKey

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