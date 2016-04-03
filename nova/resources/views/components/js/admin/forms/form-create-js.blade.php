<script>
	vue = {
		data: {
			name: "",
			key: ""
		},

		methods: {
			updateName: function () {
				this.key = this.name.replace(/\W+/g, '-').toLowerCase()

				this.updateKey()
			},

			updateKey: function () {
				if (this.key != "") {
					var url = "{{ route('admin.forms.checkKey') }}"
					var postData = { key: this.key }

					this.$http.post(url, postData).then(function (response) {
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
					}, function (response) {
						swal({
							title: "Error!",
							text: "There was an error trying to check the form key. Please try again. (Error " + response.status + ")",
							type: "error",
							timer: null,
							html: true
						})
					})
				}
			}
		}
	}
</script>