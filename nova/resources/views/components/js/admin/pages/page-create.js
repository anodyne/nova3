vue = {
	data: {
		type: "",
		key: "",
		uri: "",
		//accessType: "",
		//access: [],
		//accessRole: [],
		//accessPermission: [],
		//permissionData: [],
		name: "",
		description: "",
		menu: "",
		resource: "",
		verb: "",
		uriConditions: "",
		contentTitle: "",
		contentHeader: "",
		contentMessage: "",
		roles: Nova.data.roles,
		permissions: Nova.data.permissions,
		metadata: [
			{ name: "og:title", value: "" },
			{ name: "twitter:title", value: "" },
			{ name: "description", value: "" }
		]
	},

	methods: {
		addMetadata: function () {
			this.metadata.push({ name: "", value: "" })
		},

		removeMetadata: function (row) {
			this.metadata.$remove(row)
		},

		pickerClassName: function (type) {
			if (this.type == type) {
				return 'card picker card-primary card-inverse'
			}

			return 'card picker'
		},

		checkKey: function () {
			if (this.key != "") {
				var url = Nova.data.keyCheckUrl
				var postData = { key: this.key }

				this.$http.post(url, postData).then(response => {
					if (response.data.code == 0) {
						this.key = ""

						swal({
							title: "Error!",
							text: "Page keys must be unique. Another page is already using the key [" + postData.key + "]. Please enter a unique key.",
							type: "error",
							timer: null,
							html: true
						})
					}
				}, response => {
					swal({
						title: "Error!",
						text: "There was an error trying to check the page key. Please try again. (Error " + response.status + ")",
						type: "error",
						timer: null,
						html: true
					})
				})
			}
		},

		checkUri: function () {
			if (this.uri != "") {
				var url = Nova.data.uriCheckUrl
				var postData = { uri: this.uri }

				this.$http.post(url, postData).then(response => {
					if (response.data.code == 0) {
						this.uri = ""

						swal({
							title: "Error!",
							text: "You've entered a URI that's already being used by another page. Please enter a different URI for this page.",
							type: "error",
							timer: null,
							html: true
						})
					} else {
						// Change all slashes into periods
						var newKey = this.uri.replace(/\//g, ".");

						// Take out all the URI variables
						newKey = newKey.replace(/{(.*?)}/g, "");

						// If we have consecutive periods, make them 1
						newKey = newKey.replace(/\.{2,}/g, ".");

						// Take periods off the beginning of the string
						if (newKey.charAt(0) == ".")
							newKey = newKey.substr(1);

						// Take periods off the end of the string
						if (newKey.slice(-1) == ".")
							newKey = newKey.substring(0, newKey.length - 1);

						this.key = newKey
					}
				}, response => {
					swal({
						title: "Error!",
						text: "There was an error trying to check the URI. Please try again. (Error " + response.status + ")",
						type: "error",
						timer: null,
						html: true
					})
				})
			}
		},

		updateType: function () {
			//
		}
	}
}