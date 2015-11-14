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
			this.$http.get(this.baseUrl + '/api/pages', function (data, status, request)
			{
				this.pages = data.data
			}).error(function (data, status, request)
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