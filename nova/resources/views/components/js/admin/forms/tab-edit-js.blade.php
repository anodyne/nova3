<script>
	vue = {
		data: {
			link: "",
			name: "",
			formKey: "",
			oldLink: ""
		},

		ready: function()
		{
			this.oldLink = this.link
		}

		methods: {
			updateName: function()
			{
				this.link = this.name.replace(/\W+/g, '-').toLowerCase()

				this.updateLink()
			},

			updateLink: function()
			{
				if (this.link != "" && this.link != this.oldLink)
				{
					var url = "{{ route('admin.forms.tabs.checkLink') }}"
					var postData = {
						linkId: this.link,
						formKey: this.formKey
					}

					this.$http.post(url, postData).then(function (response)
					{
						if (response.code == 0)
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
					}, function (response)
					{
						swal({
							title: "Error!",
							text: "There was an error trying to check the link ID. Please try again. (Error " + response.status + ")",
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