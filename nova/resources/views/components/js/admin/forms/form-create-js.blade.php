<script>
	vue = {
		data: {
			key: "",
			name: "",
			restrictions: [
				{ type: "view", value: "" },
				{ type: "add", value: "" },
				{ type: "edit", value: "" },
				{ type: "remove", value: "" }
			],
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
				if (this.key != "") {
					var url = "{{ route('admin.forms.checkKey') }}"
					var postData = { key: this.key }

					this.$http.post(url, postData).then(response => {
						if (response.code == 0) {
							this.key = ""

							swal({
								title: "Error!",
								text: "Form keys must be unique. Another form is already using the key [" + postData.key + "]. Please enter a unique key.",
								type: "error",
								timer: null,
								html: true
							})
						}
					}, response => {
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

		watch: {
			useFormCenter: function (value, oldValue) {
				if (value == false) {
					//
				}
			}
		}
	}
</script>