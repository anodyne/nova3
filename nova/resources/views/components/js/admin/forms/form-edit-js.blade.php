<script>
	vue = {
		data: {
			name: "",
			key: "",
			oldKey: ""
		},

		ready: function()
		{
			this.oldKey = this.key
		},

		methods: {
			updateName: function()
			{
				this.key = this.name.replace(/\W+/g, '-').toLowerCase()

				this.updateKey()
			},

			updateKey: function()
			{
				if (this.key != "" && this.key != this.oldKey)
				{
					var url = "{{ route('admin.forms.checkKey') }}"
					var postData = { key: this.key }

					this.$http.post(url, postData, function (data, status, request)
					{
						if (data.code == 0)
						{
							this.key = this.oldKey

							swal({
								title: "Error!",
								text: "Form keys must be unique. Another form is already using the key [" + postData.key + "]. Please enter a unique key.",
								type: "error",
								timer: null,
								html: true
							})
						}
					}).error(function (data, status, request)
					{
						swal({
							title: "Error!",
							text: "There was an error trying to check the form key. Please try again. (Error " + status + ")",
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