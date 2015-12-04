<script>
	vue = {
		data: {
			link: "",
			name: "",
			formKey: ""
		},

		methods: {
			updateName: function()
			{
				this.link = this.name.replace(/\W+/g, '-').toLowerCase()

				this.updateLink()
			},

			updateLink: function()
			{
				if (this.link != "")
				{
					var url = "{{ route('admin.forms.tabs.checkLink') }}"
					var postData = {
						linkId: this.link,
						formKey: this.formKey
					}

					this.$http.post(url, postData, function (data, status, request)
					{
						if (data.code == 0)
						{
							this.link = ""

							swal({
								title: "Error!",
								text: "Link IDs must be unique. Another tab is already using the link ID [" + postData.linkId + "]. Please enter a unique link ID.",
								type: "error",
								timer: null,
								html: true
							})
						}
					}).error(function (data, status, request)
					{
						swal({
							title: "Error!",
							text: "There was an error trying to check the link ID. Please try again. (Error " + status + ")",
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