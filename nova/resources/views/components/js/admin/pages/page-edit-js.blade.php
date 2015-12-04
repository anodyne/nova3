<script>
	vue = {
		data: {
			resource: "",
			type: "",
			key: "",
			uri: "",
			oldKey: "",
			oldUri: ""
		},

		ready: function()
		{
			this.oldKey = this.key
			this.oldUri = this.uri
		},

		methods: {
			resetResource: function()
			{
				this.resource = ''
			},

			checkKey: function()
			{
				if (this.key != "" && this.key != this.oldKey)
				{
					var url = "{{ route('admin.pages.checkKey') }}"
					var postData = { key: this.key }

					this.$http.post(url, postData, function (data, status, request)
					{
						if (data.code == 0)
						{
							this.key = this.oldKey

							swal({
								title: "Error!",
								text: "Page keys must be unique. Another page is already using the key [" + postData.key + "]. Please enter a unique key.",
								type: "error",
								timer: null,
								html: true
							})
						}
					}).error(function (data, status, request)
					{
						swal({
							title: "Error!",
							text: "There was an error trying to check the page key. Please try again. (Error " + status + ")",
							type: "error",
							timer: null,
							html: true
						})
					})
				}
			},

			checkUri: function()
			{
				if (this.uri != "" && this.uri != this.oldUri)
				{
					var url = "{{ route('admin.pages.checkUri') }}"
					var postData = { uri: this.uri }

					this.$http.post(url, postData, function (data, status, request)
					{
						if (data.code == 0)
						{
							this.uri = this.oldUri

							swal({
								title: "Error!",
								text: "You've entered a URI that's already being used by another page. Please enter a different URI for this page.",
								type: "error",
								timer: null,
								html: true
							})
						}
						else
						{
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
					}).error(function (data, status, request)
					{
						swal({
							title: "Error!",
							text: "There was an error trying to check the URI. Please try again. (Error " + status + ")",
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