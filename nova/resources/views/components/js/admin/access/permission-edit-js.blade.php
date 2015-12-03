<script>
	vue = {
		data: {
			key: ""
		},

		methods: {
			updateKey: function()
			{
				if (this.key != "")
				{
					var url = "{{ route('admin.access.permissions.checkKey') }}"
					var postData = { key: this.key }

					this.$http.post(url, postData, function (data, status, request)
					{
						if (data.code == 0)
						{
							this.key = ""

							swal({
								title: "Error!",
								text: "Permission keys must be unique. Another permission is already using the key [" + postData.key + "]. Please enter a unique key.",
								type: "error",
								timer: null,
								html: true
							})
						}
					}).error(function (data, status, request)
					{
						swal({
							title: "Error!",
							text: "There was an error trying to check the permission key. Please try again. (Error " + status + ")",
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