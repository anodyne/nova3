vue = {
	data: {
		allowMultipleSubmissions: "",
		entryIdentifier: "",
		key: "",
		name: "",
		orientation: "",
		resourceDestroy: "",
		resourceStore: "",
		resourceUpdate: "",
		restrictions: [
			{ type: "view", value: "" },
			{ type: "add", value: "" },
			{ type: "edit", value: "" },
			{ type: "remove", value: "" }
		],
		status: "",
		useFormCenter: true
	},

	methods: {
		clearRestriction: function (row) {
			for (var i = 0; i < this.restrictions.length; ++i) {
				if (this.restrictions[i] === row) {
					this.restrictions[i].value = ""
					break
				}
			}
		},

		updateKey: function () {
			if (this.key != "" && this.key != this.oldKey) {
				var url = Nova.data.keyCheckUrl
				var postData = { key: this.key }

				this.$http.post(url, postData).then(response => {
					if (response.data.code == 0) {
						$('[name="key"]').blur()
						this.key = this.oldKey

						swal({
							title: "Error!",
							text: "Form keys must be unique. Another form is already using the key [" + postData.key + "]. Please enter a unique key.",
							type: "error",
							timer: null,
							html: true
						})
					}
				}, response => {
					$('[name="key"]').blur()
					this.key = this.oldKey

					swal({
						title: "Error!",
						text: "There was an error trying to check the form key. Please try again. (Error " + response.status + ")",
						type: "error",
						timer: null,
						html: true
					})
				})
			}
		},

		updateName: function () {
			this.key = this.name.replace(/\W+/g, '-').toLowerCase()

			this.updateKey()
		}
	},

	ready: function () {
		this.oldKey = this.key

		var restrictions = Nova.data.restrictions
		var form = Nova.data.form

		if (restrictions) {
			this.restrictions = []

			for (var r = 0; r < restrictions.length; ++r) {
				this.restrictions.push({ type: restrictions[r].type, value: restrictions[r].value })
			}
		}

		this.useFormCenter = form.use_form_center
	}
}