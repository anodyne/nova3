<script>
	vue = {
		data: {
			component: "",
			action: ""
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
					var url = "{{ route('admin.access.permissions.checkKey') }}"
					var postData = { key: this.key }

					this.$http.post(url, postData).then(function (response) {
						if (response.code == 0) {
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
					}, function (response) {
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
</script>