<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			search: "",
			verbs: [],
			pages: []
		},

		methods: {
			removePage: function(pageId)
			{
				$('#removePage').modal({
					remote: "{{ url('admin/pages') }}/" + pageId + "/remove"
				}).modal('show')
			},

			resetFilters: function()
			{
				this.search = ""
				this.verbs = []
			}
		},

		ready: function()
		{
			this.$http.get(this.baseUrl + '/api/pages').then(function (response)
			{
				this.pages = response.data
			}, function (response)
			{
				this.loadingWithError = true
			})
		},

		watch: {
			"pages": function (value, oldValue)
			{
				if (value.length > 0)
					this.loading = false
			}
		}
	}
</script>